<div dir="rtl" style="font-size:17px;padding-bottom:20px;">
    <p>
        کاربر گرامی :
        <a href="mailto:{{ $email }}" style="color: rgb(16, 138, 182);text-decoration: none">
            {{ $email }}
        </a>
    </p>
    <p>سلام</p>
    <p>این ایمیل برای تایید حساب کاربری شما ارسال شده است</p>
    <p>برای تایید حساب کاربری لینک زیر را باز کنید:</p>
    <a href="{{ $verify_url }}"
        style="font-size: 20px; margin-top: 30px;text-decoration: none;color: white;background-color: deepskyblue;border-radius: 10px;padding: 8px 14px;display: flex;width: fit-content;">
        تایید حساب
    </a>
</div>
