<?php

namespace App\Database\Models;

use Exception;

use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

use App\Classes\Base\Database\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $appends = ['status_fa'];
    protected $casts = ['extra' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function address()
    {
        return $this->hasOne(OrderAddress::class, "order_id");
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, "order_id");
    }
    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class, "order_id");
    }

    public function payWithIPG($user)
    {
        $invoice = new Invoice();
        $invoice->amount($this->payment_cost);
        $invoice->detail(["email" => $user->email, "mobile" => $user->phone, "description" => "پرداخت سفارش محصولات"]);

        try {
            $payment =  Payment::callbackUrl(_route("payment-callback"))->purchase($invoice);
        } catch (Exception $ex) {
            return redirect("/")->_withMessage($ex->getMessage());
        }
        // invoice transaction id will be populated after purchasing invoice otherwise it is null by default
        $this->transactions()->create([
            "transaction_id" => $invoice->getTransactionId(),
            "amount" => $invoice->getAmount(),
            "email" => $invoice->getDetail("email"),
            "mobile" => $invoice->getDetail("mobile"),
            "description" => $invoice->getDetail("description"),
        ]);

        $pg_redirection = $payment->pay();
        $token = PaymentRedirectionToken::createJwtToken($pg_redirection->jsonSerialize())->token;

        return redirect()->_route("payment-redirect", compact('token'));
    }

    protected function statusFa(): CastAttribute
    {
        return CastAttribute::get(function () {
            switch ($this->status) {
                case "delivered":
                    return "تحویل داده شده";
                case "canceled":
                    return "لغو شده";
                case "pending":
                    return "در انتظار پرداخت";
                case "returned":
                    return "مرجوع شده";
                case "processing":
                    return "در حال پردازش";
            }
        });
    }
}
