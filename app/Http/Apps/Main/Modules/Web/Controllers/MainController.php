<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers;

use Exception;

use Shetabit\Payment\Facade\Payment;

use App\Classes\Base\Routing\Controller;
use App\Database\Models\Brand;
use App\Database\Models\Cart;
use App\Database\Models\Category;
use App\Database\Models\Product;
use App\Database\Models\Coupon;
use App\Database\Models\OTP;
use App\Database\Models\PaymentRedirectionToken;
use App\Database\Models\PhoneOTPToken;
use App\Database\Models\PaymentTransaction;
use App\Database\Models\Post;
use App\Database\Models\User;

use App\Http\Apps\Main\Validations\Main as MainValidations;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function getIndex()
    {
        $special_offer_products = Product::select("products.*")->withSelectedSu(["conditions" => ["only_discounted" => true], "on_join" => fn ($join) => $join->where("selected_products_su.discount_percent", ">", 20)])->withUserFavouriteCheck()->with("image")->limit(10)->get();
        $best_selling_products = Product::select("products.*")->withSelectedSu()->withUserFavouriteCheck()->with("image")->orderBy("products.sales", "desc")->limit(10)->get();
        $latest_products = Product::select("products.*")->withSelectedSu()->withUserFavouriteCheck()->with("image")->orderBy("products.published_at", "desc")->limit(10)->get();
        $latest_posts = Post::with("image")->orderBy("published_at", "desc")->limit(10)->get();
        $popular_categories = Category::withCount("products")->where("level", 1)->limit(6)->get();
        $popular_brands = Brand::limit(10)->get();
        return view("pages.main.index", compact("best_selling_products", "special_offer_products", "latest_products", "latest_posts", "popular_categories", "popular_brands"));
    }
    public function getCheckout()
    {
        $cart = Cart::getRequestCart();
        if (!_user()->phone) return back()->_withMessage("برای ثبت سفارش ابتدا باید شماره همراه خود را ثبت کرده باشید", "info");
        if (!($cart && $cart->items()->exists())) return redirect("/cart")->_withMessage("سبد خرید شما خالی است", "warning");
        _user()->load(["addresses" => fn ($query) => $query->orderBy("created_at", "desc")]);
        return view("pages.main.checkout");
    }
    public function postCheckout()
    {
        $cart = Cart::getRequestCart();
        $req = request();
        $user = _user();
        $address = null;
        if (!($cart && count($cart->items) > 0)) return redirect("/cart")->_withMessage("سبد خرید شما خالی است", "warning");
        $validated = MainValidations::checkout($req->input())->after(function ($errors) use (&$address, $req, $user) {
            if (!$errors->has("address") && !($address = $user->addresses()->find($req->input("address")))) {
                $errors->add("address", "آدرس انتخاب شده صحیح نیست");
            }
        })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated, true)->withInput();
        $req->_trimOnly("description", true);
        $coupon = Coupon::getRequestCoupon();
        $cart->items->load("productSu");
        $cart_info = $cart->getInfo($coupon);
        $order = $user->orders()->create(["payment_method" => "online", 'payment_cost' => $cart_info['payment_cost'], "extra" => collect($cart_info)->except("coupon", "payment_cost"), "description" => $req->input("description")]);
        $order->address()->create([
            'recipient_fullname' => $address->recipient_fullname,
            'recipient_email' => $address->recipient_email,
            'recipient_phone' => $address->recipient_phone,
            'postal_address' => $address->postal_address,
            'postal_code' => $address->postal_code,
            'city_id' => $address->city_id,
            'province_id' => $address->province_id,
        ]);
        foreach ($cart->items as $item) {
            $order->items()->create(["quantity" => $item->quantity, "product_su_price" => $item->productSu->price, "product_su_discounted_price" => $item->productSu->discounted_price, "product_su_id" => $item->productSu->id]);
            $item->productSu->stock -= $item->quantity;
            $item->productSu->save();
        }
        if ($coupon) {
            $coupon->update(['is_used' => true]);
            session()->forget("coupon_id");
        }
        // clear cart items
        $cart->items()->delete();

        return $order->payWithIPG($user);
    }
    public function getPaymentRedirect()
    {
        $req = request();
        $token = $req->query("token");
        $pg_redirection = null;

        if ($token) {
            try {
                $pg_redirection = PaymentRedirectionToken::verifyJwtToken($token);
            } catch (Exception $ex) {
            }
        }
        if (!$pg_redirection) return redirect("/")->_withMessage("مشکلی در فرایند انتقال به درگاه پرداخت پیش آمده است", "warning");

        return view("pages.main.payment-redirection", ["redirection" => $pg_redirection]);
    }
    public function getPaymentCallback()
    {
        $req = request();
        $transaction_id = $req->query("Authority");
        if (!($transaction_id && ($transaction = PaymentTransaction::where("transaction_id", $transaction_id)->first()))) _http_abort(404);

        try {
            $receipt = Payment::amount($transaction->amount)->transactionId($transaction_id)->verify();
            $transaction->update(['is_done' => true, 'ref_id' => $receipt->getReferenceId()]);
            $transaction->order()->_updateFirst(["status" => "processing"]);
            return redirect("/")->_withMessage("سفارش با موفقیت پرداخت شد", "success");
        } catch (Exception $ex) {
            return redirect("/")->_withMessage("پرداخت سفارش ناموفق بود", "danger");
        }
    }
    public function getWishlist()
    {
        $user = _user();
        $products = $user->favoredProducts()->select("products.*")->withSelectedSu()->orderByPivot("created_at", "desc")->with("image")->get();
        dd($products);
        return view("pages.main.wishlist", ["products" => $products]);
    }
    public function getCompare(...$comparable_product_ids)
    {
        if (!count($comparable_product_ids)) _http_abort(404);
        $comparable_products = Product::select("products.*")->withSelectedSu()->whereIn("products.id", $comparable_product_ids)->with("mainCategory.comparableCategories", "properties", "image")->get();
        if (count($comparable_products) !== count($comparable_product_ids)) _http_abort(404);

        if (count($comparable_products) > 1) {
            foreach ($comparable_products as $key => $product) {
                foreach ($comparable_products->except($key) as $comparable) {
                    if (!$product->mainCategory->comparableCategories->some(fn ($category) => $category->id === $comparable->mainCategory->id)) _http_abort(404);
                }
            }
        }

        $comparable_properties = $comparable_products->pluck("mainCategory")->flatMap(fn ($category) => $category->properties()->where("properties.is_comparable", true)->get())->unique("id");

        return view("pages.main.compare", compact('comparable_products', 'comparable_properties'));
    }
    public function getProduct($product_id, $product_slug = null)
    {
        $req = request();
        $user = _user();
        $product = Product::published()->findOrFail($product_id);
        if (!($product->selected_su = $product->getSelectedSu())) _http_abort(404);
        if (!($product_slug && $product_slug === $product->slug)) return redirect()->_route("product", ["product_id" => $product_id, "product_slug" => $product->slug]);
        // user visit
        if (!$product->visits()->where("user_ip", $req->ip())->exists()) $product->visits()->create(["user_ip" => $req->ip()]);
        // user favourite
        if ($user) $product->is_user_favourite = $product->favoredByUsers()->where("users.id", $user->id)->exists();
        // brand
        $product->brand = $product->brand()->first();
        // image
        $product->image = $product->image()->first();
        // thumbnails
        $product->thumbnails = $product->thumbnails()->_ordered()->get();
        // tags
        $product->tags = $product->tags()->_orderedByPivot()->get();
        // categories
        $product->categories = $product->categories()->orderBy("level")->get();
        // main category
        $product->main_category = $product->mainCategory()->first();
        // specifications
        $product->specification_groups = $product->specificationGroups()->_ordered()->with(["items" => fn ($query) => $query->_ordered()])->get();
        // comments
        $product->comments_paginator = $product->comments()->with("user.profileImage")->where("is_verified", true)->latest()->_basePaginate(["page" => 1, "limit" => 9])->withPath("/ajax/products/$product->id/comments");
        // variable type
        if ($product->is_variable)  $product->variable_type = ["variations" => $product->variableTypeVariations()->with(["variableProductTypeAttributes" => fn ($query) => $query->_orderedByPivot()])->active()->inStock()->_ordered()->get(), "attributes" => $product->variableTypeAttributes()->_orderedByPivot()->get()];
        // related products
        $product->related_products = $product->main_category->products()->select("products.*")->withSelectedSu()->withUserFavouriteCheck()->where("products.id", "!=", $product->id)->orderBy("avg_rating")->limit(10)->with("image")->get();

        $product->makeHidden('product', 'related_products', 'specification_groups', 'brand', 'categories', 'tags', 'comments_paginator', 'thumbnails', 'image');
        return view("pages.main.product", compact('product'));
    }
    public function postProductComment($product_id)
    {
        $user = _user();
        $req = request();
        $product = Product::published()->find($product_id);
        if (!$product) _http_abort(404);
        if ($product->comments()->where("user_id", $user->id)->exists()) return back()->_withMessage("دیدگاه شما قبلا ثبت شده است", "info");
        $validated = MainValidations::productComment($req->input())->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $product->comments()->create(array_merge(["user_id" => $user->id], $req->only("rating", "text")));
        return back()->_withMessage("دیدگاه شما ثبت و بعد از تایید نمایش داده خواهد شد", "success");
    }
    public function getToggleFavouriteProduct($product_id)
    {
        $user = _user();
        $product = Product::published()->find($product_id);
        if (!$product) _http_abort(404);
        $is_user_favourite = false;
        if (!$user->favoredProducts()->detach($product_id)) {
            $user->favoredProducts()->attach($product_id);
            $is_user_favourite = true;
        }
        return back()->_withMessage($is_user_favourite ? "محصول به علاقه مندی ها اضافه شد" : "محصول از علاقه مندی ها حذف شد", "success");
    }
    public function getShop($category_slug)
    {
        $category = Category::where("slug", $category_slug)->with("children")->firstOrFail();

        $paginator = Product::aggregateByCategory($category);

        // parent categories
        function get_parent_categories($category)
        {
            $parents = [];
            if (!$category->parent_id) return $parents;
            $parent = $category->parent()->first();
            if ($parent->parent_id) {
                array_push($parents, ...get_parent_categories($parent));
            }
            $parents[] = $parent;
            return $parents;
        }
        $category->parents = get_parent_categories($category);
        // category brands
        $category->brands = $category->brands()->_orderedByPivot()->get();
        // category properties
        $category->properties = $category->properties()->_orderedByPivot()->with(["pivot.values" => fn ($query) => $query->_orderedByPivot()])->get();
        // category attributes
        $category->attributes = $category->attributes()->_orderedByPivot()->with(["pivot.values" => fn ($query) => $query->_orderedByPivot()])->get();

        return view("pages.main.shop", compact('paginator', 'category'));
    }
    public function getSearch()
    {
        $req = request();
        $search_term = $req->query("q");
        $tag = $req->query("tag");
        if ($search_term === null && $tag === null) _http_abort(404);
        $request_query_result = [];
        $paginator = Product::aggregateBySearch($search_term, $tag, $request_query_result);

        $brands = Brand::all();
        $categories = Category::where("level", 1)->get();

        return view("pages.main.search", compact("paginator", "brands", "categories", 'request_query_result'));
    }
    public function getPost($post_id, $post_slug = null)
    {
    }
    public function postProfilePhone()
    {
        $req = request();
        $req->_trimAll();
        $phone = $req->input("phone");
        $validated = MainValidations::phone($req->input())->after(function ($errors) use ($phone) {
            if (!$errors->has("phone")) {
                if ($existing_user = User::where("phone", $phone)->first()) {
                    if ($existing_user->id === _user()->id) $errors->add("phone", "شماره موبایل جدید نمیتواند تکراری باشد");
                    else $errors->add("phone", "کاربری با این شماره موبایل موجود است");
                }
            }
        })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $phone_token = PhoneOTPToken::createJwtToken(["phone" => $phone], 60 * 30);
        return redirect()->_route("profile-phone-verify", ["token" => $phone_token->token]);
    }
    public function getProfilePhoneResendOTP()
    {
        $req = request();
        $token = $req->query("token");
        $phone = $this->retrievePhoneByToken($token);
        if (!$phone) return back()->_withMessage("مشکلی در ارسال مجدد کد تایید پیش آمده است", "danger");
        $current_otp = OTP::where(["phone" => $phone, "type" => "profile"])->latest()->first();
        $message_status = "success";
        if ($current_otp) {
            if (($current_otp->created_at->diffInSeconds(now())) < 180) {
                $message_status = "info";
                $message = "کد تایید قبلا برای شما ارسال شده است";
            } else {
                $message = "کد تایید مجددا برای شما ارسال شد";
            }
        } else {
            $message = "کد تایید برای شما ارسال شد";
        }
        return redirect()->_route("profile-phone-verify", ["token" => $token])->_withMessage($message, $message_status);
    }
    public function getProfilePhoneVerify()
    {
        $req = request();
        $token = $req->query("token");
        $phone = $this->retrievePhoneByToken($token);
        if (!$phone) return back()->_withMessage("مشکلی در ارسال کد تایید پیش آمده است", "danger");
        $current_otp = OTP::where(["phone" => $phone, "type" => "profile"])->latest()->first();
        if ($current_otp && ($diff = $current_otp->created_at->diffInSeconds(now())) < 180) {
            $timeout = 180 - $diff;
        } else {
            $otp_code = rand(1000000, 9999999);
            OTP::create(["code" => $otp_code, "phone" => $phone, "type" => "profile"]);
            $timeout = 180;
        }
        return view("pages.main.profile-phone-verify", ["composers" => ['main'], "otp_resend_timeout" => $timeout, "phone" => $phone]);
    }
    public function postProfilePhoneVerify()
    {
        $user = _user();
        $req = request();
        $req->_trimAll();
        $token = $req->query("token");
        $otp_code = $req->input("code");
        $phone = $this->retrievePhoneByToken($token, $phone_otp_token);
        if (!$phone) return back()->_withMessage("مشکلی در تایید شماره موبایل پیش آمده است", "danger");
        $validated = MainValidations::otpVerification($req->input())->after(function ($errors) use ($phone, $otp_code, $phone_otp_token) {
            if (!$errors->has("otp")) {
                if ($existing_otp = OTP::where(["phone" => $phone, "code" => $otp_code])->first()) {
                    if ($existing_otp->created_at->diffInSeconds(now()) <= 120) {
                        $phone_otp_token->delete();
                        $existing_otp->delete();
                        return;
                    }
                }
                $errors->add("code", "کد تایید اشتباه است");
            }
        })->validate();
        if ($validated->failed) return back()->_withValidationResult($validated)->withInput();
        $message = $user->phone ? "شماره موبایل شما با موفقیت تغییر کرد" : "شماره موبایل جدید ثبت شد";
        $user->phone = $phone;
        $user->save();
        return redirect()->_route("users.profile")->_withMessage($message, "success");
    }
    // ProfilePhone
    private function retrievePhoneByToken($token, &$phone_otp_token = null)
    {
        if ($token) {
            try {
                $phone_otp_token = PhoneOTPToken::verifyJwtToken($token);
                return $phone_otp_token->phone ?? null;
            } catch (Exception $ex) {
            }
        }
    }
}
