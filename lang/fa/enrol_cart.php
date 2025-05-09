<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Shopping Cart Enrolment Plugin for Moodle
 *
 * @package     enrol_cart
 * @author      MohammadReza PourMohammad <onbirdev@gmail.com>
 * @copyright   2024 MohammadReza PourMohammad
 * @link        https://onbir.dev
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'سبد خرید';
$string['pluginname_desc'] =
    'روش ثبت نام با سبد خرید، یک سبد خرید در کل سایت ایجاد کرده و امکان اضافه کردن دوره به سبد خرید و خرید دوره را فراهم می‌کند.';
$string['privacy:metadata:reason'] = 'افزونه enrol_cart به طور مستقیم هیچ اطلاعات کاربری را ذخیره نمی‌کند.';
$string['privacy:metadata:enrol_cart'] = 'جزئیات مربوط به سبدهای خرید مورد استفاده برای ثبت‌نام.';
$string['privacy:metadata:enrol_cart:user_id'] = 'شناسه کاربری مرتبط با این سبد خرید.';
$string['privacy:metadata:enrol_cart:status'] = 'وضعیت سبد خرید (مانند در انتظار، تکمیل‌شده).';
$string['privacy:metadata:enrol_cart:currency'] = 'واحد پولی مورد استفاده در این سبد خرید.';
$string['privacy:metadata:enrol_cart:price'] = 'قیمت کل سبد خرید.';
$string['privacy:metadata:enrol_cart:payable'] = 'مبلغ قابل پرداخت در سبد خرید.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'شناسه کد تخفیف اعمال شده روی سبد خرید، در صورت وجود.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'کد تخفیف اعمال شده روی سبد خرید، در صورت وجود.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'زمانی که سبد خرید تسویه شده است.';
$string['privacy:metadata:enrol_cart:created_at'] = 'زمانی که سبد خرید ایجاد شده است.';
$string['privacy:metadata:enrol_cart_items'] = 'جزئیات آیتم‌های موجود در یک سبد خرید.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'شناسه سبد خرید حاوی این آیتم.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'شناسه مورد ثبت‌نام مرتبط با این آیتم.';
$string['privacy:metadata:enrol_cart_items:price'] = 'قیمت آیتم.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'مبلغ قابل پرداخت برای آیتم.';

$string['cart:config'] = 'پیکربندی ثبت نام سبد خرید';
$string['cart:manage'] = 'مدیریت کاربران ثبت نام شده';
$string['cart:unenrol'] = 'لغو ثبت نام کاربران دوره';
$string['cart:unenrolself'] = 'لغو ثبت نام من';
$string['cart:view'] = 'مشاهده سبد خرید';

$string['delete_expired_carts'] = 'حذف سبد خریدهای منقضی شده';
$string['event_cart_deleted'] = 'سبد خرید حذف شد';

$string['add_to_cart'] = 'افزودن به سبد خرید';
$string['cart_is_empty'] = 'سبد خرید شما خالی است';
$string['price'] = 'مبلغ';
$string['payable'] = 'قابل پرداخت';
$string['total'] = 'جمع کل';
$string['free'] = 'رایگان';
$string['checkout'] = 'پرداخت';
$string['select_payment_method'] = 'انتخاب روش پرداخت';
$string['status_current'] = 'فعال';
$string['status_checkout'] = 'در انتظار پرداخت';
$string['status_canceled'] = 'لغو شده';
$string['status_delivered'] = 'تحویل شده';
$string['unknown'] = 'نامشخص';
$string['cart_status'] = 'وضعیت';
$string['coupon_code'] = 'کد تخفیف';
$string['coupon_discount'] = 'تخفیف کوپن';
$string['apply'] = 'ثبت';
$string['total_order_amount'] = 'جمع خرید';
$string['IRR'] = 'ریال';
$string['IRT'] = 'تومان';
$string['payment'] = 'پرداخت';
$string['pay'] = 'پرداخت';
$string['proceed_to_checkout'] = 'تایید و تکمیل خرید';
$string['discount'] = 'تخفیف';
$string['complete_purchase'] = 'نهایی کردن خرید';
$string['cancel_cart'] = 'لغو خرید';
$string['cancel'] = 'لغو';
$string['gateway_wait'] = 'درحال اتصال به درگاه پرداخت ...';
$string['order'] = 'خرید';
$string['order_id'] = 'کد خرید';
$string['my_purchases'] = 'خرید‌های من';
$string['view'] = 'مشاهده';
$string['date'] = 'تاریخ';
$string['no_items'] = 'آیتمی پیدا نشد.';
$string['no_discount'] = 'بدون تخفیف';
$string['percentage'] = 'درصد';
$string['fixed'] = 'مبلغ ثابت';
$string['never'] = 'هیچ وقت';
$string['unlimited'] = 'نامحدود';
$string['one_day'] = 'یک روز';
$string['a_week'] = 'یک هفته';
$string['one_month'] = 'یک ماه';
$string['three_months'] = 'سه ماه';
$string['six_months'] = 'شش ماه';
$string['user'] = 'کاربر';

$string['payment_account'] = 'حساب پرداخت';
$string['payment_currency'] = 'واحد پول';
$string['auto_select_payment_gateway'] = 'انتخاب خودکار درگاه پرداخت';
$string['auto_select_payment_gateway_desc'] =
    'با انتخاب این گزینه کاربر بدون نیاز به انتخاب درگاه به سمت یکی از درگاه پرداخت‌های بالا هدایت می‌شود.';
$string['canceled_cart_lifetime'] = 'مدت زمان نگهداری سبد خریدهای لغو شده';
$string['canceled_cart_lifetime_desc'] =
    'سبد خریدهای <b>لغو شده</b> بعد از مدت زمان تعیین شده بطور کامل حذف خواهند شد. مقدار صفر به معنی نامحدود می‌باشد.';
$string['pending_payment_cart_lifetime'] = 'مدت زمان نگهداری سبد خریدهای در انتظار پرداخت';
$string['pending_payment_cart_lifetime_desc'] =
    'سبد خریدهای <b>در انتظار پرداخت</b> بعد از مدت زمان تعیین شده بطور کامل حذف خواهند شد. مقدار صفر به معنی نامحدود می‌باشد.';
$string['verify_payment_on_delivery'] = 'مطابقت مبلغ نهایی با پرداختی موقع تحویل';
$string['verify_payment_on_delivery_desc'] =
    'با انتخاب این گزینه هنگام تحویل سبد خرید، مبلغ نهایی سبد خرید با مبلغ پراختی مقایسه خواهد شد و در صورت برابر بودن سبد خرید تحویل خواهد شد.';
$string['convert_irr_to_irt'] = 'تبدیل ریال به تومان';
$string['convert_irr_to_irt_desc'] =
    'با انتخاب این گزینه مبلغ‌های ریال ایران به واحد تومان تبدیل و نمایش داده خواهند شد. <b>(این تنظیم صرفا در حالت نمایش مبلغ برای کاربر کاربرد دارد در هنگام ایجاد یا ویرایش روش ثبت نام مبلغ باید همچنان به ریال وارد شود.)</b>';
$string['convert_numbers_to_persian'] = 'تبدیل اعداد انگلیسی به فارسی';
$string['convert_numbers_to_persian_desc'] =
    'با انتخاب این گزینه در زمان نمایش مبلغ، اعداد انگلیسی به فارسی تبدیل خواهند شد.';
$string['enrol_instance_defaults'] = 'پیش‌فرض‌های ثبت نام';
$string['enrol_instance_defaults_desc'] = 'تنظیمات پیش‌فرض مربوط به ثبت نام در درس‌های جدید';
$string['payment_completion_time'] = 'مدت زمان تکمیل پرداخت';
$string['payment_completion_time_desc'] =
    'این متغیر مشخص می‌کند که پس از اقدام به پرداخت، کاربر حداکثر تا چه مدت زمانی می‌تواند پرداخت خود را کامل انجام دهد. در طول این مدت آیتم‌ها، مبلغ سبد خرید و کد تخفیف جهت پرداخت کاربر قفل می‌شوند.';
$string['choose_gateway'] = 'انتخاب درگاه پرداخت:';
$string['coupon_enable'] = 'فعال بودن کوپن تخفیف';
$string['coupon_enable_desc'] =
    'سبد خرید امکان استفاده از کوپن تخفیف را پشتیبانی می‌کنید در صورتیکه پلاگین کوپن تخفیف در سسیستم باشد استفاده از آن در سبد خرید امکان پذیر می‌باشد.';
$string['coupon_class'] = 'کلاس کوپن تخفیف';
$string['coupon_class_desc'] =
    'مسیر کلاس کوپن تخفیف را مشخص کنید. مانند: <code dir="ltr">local_coupon\object\coupon</code> کلاس کوپن تخفیف باید <code dir="ltr">enrol_cart\local\object\coupon_interface</code> را اجرا کند.';
$string['not_delete_cart_with_payment_record'] = 'عدم حذف سبد خرید های دارای رکورد پرداخت';
$string['not_delete_cart_with_payment_record_desc'] =
    'در صورت انتخاب این گزینه سبد خرید های دارای رکورد در جدول payment حذف نخواهند شد.';
$string['enable_guest_cart'] = 'اجازه به مهمان‌ها برای افزودن و حذف دوره از سبد خرید';
$string['enable_guest_cart_desc'] = 'اگر این گزینه فعال شود، کاربران مهمان می‌توانند دوره‌ها را به سبد خرید اضافه کرده و در صورت نیاز آن‌ها را حذف کنند.';

$string['status'] = 'فعال بودن ثبت‌نام با سبد خرید';
$string['status_desc'] = 'به کاربران امکان می دهد به صورت پیش فرض یک دوره را به سبد خرید اضافه کنند.';
$string['payment_account_help'] = 'مبالغ پرداخت شده به این حساب واریز خواهد شد.';
$string['cost'] = 'مبلغ';
$string['cost_help'] = 'مبلغ دوره می‌توانید از ۰ شروع شود. مقدار ۰ به معنی رایگان بودن دوره می‌باشد.';
$string['currency'] = 'واحد پول';
$string['discount_type'] = 'نوع تخفیف';
$string['discount_amount'] = 'مقدار تخفیف';
$string['assign_role'] = 'نقش';
$string['assign_role_desc'] = 'نقش کاربران بعد از پرداخت و ثبت نام در درس.';
$string['enrol_period'] = 'مدت زمان ثبت نام';
$string['enrol_period_desc'] = 'مدت زمانی که کاربران در درس ثبت نام باقی می مانند. مقدار صفر به معنی نامحدود می‌باشد.';
$string['enrol_period_help'] =
    'مدت زمان مجاز ثبت نام ماندن کاربر در دوره که بعد از تاریخ ثبت نام شروع می‌شود. مقدار صفر به معنی نامحدود می‌باشد.';
$string['enrol_start_date'] = 'تاریخ شروع ثبت نام';
$string['enrol_start_date_help'] = 'در صورت فعال بودن کاربران از تاریخ مشخص شده می‌توانند ثبت نام کنند.';
$string['enrol_end_date'] = 'تاریخ پایان ثبت نام';
$string['enrol_end_date_help'] = 'در صورت فعال بودن کاربران تا پایان تاریخ مشخص شده می‌توانند ثبت نام کنند.';

$string['error_no_payment_accounts_available'] = 'هیچ حساب پرداختی موجود نیست.';
$string['error_no_payment_currency_available'] =
    'هیچگونه پرداخت به هیچ واحد پولی قابل انجام نیست. لطفا مطمئن شوید که حداقل یک درگاه پرداخت فعال باشد.';
$string['error_no_payment_gateway_available'] =
    'هیچگونه درگاه پرداختی در دسترس نیست. برای انتخاب درگاه پرداخت ابتدا حساب پرداخت و درگاه پرداخت را مشخص نمایید.';
$string['error_enrol_end_date'] = 'تاریخ پایان ثبت نام نمی‌تواند قبل تر از تاریخ شروع باشد.';
$string['error_cost'] = 'مبلغ باید عدد باشد.';
$string['error_status_no_payment_account'] = 'فعال سازی روش ثبت نام سبد خرید بدون حساب پرداخت امکان پذیر نمی‌باشد.';
$string['error_status_no_payment_currency'] = 'فعال سازی روش ثبت نام سبد خرید بدون واحد پول امکان پذیر نمی‌باشد.';
$string['error_invalid_cart'] = 'سفارش نامعتبر';
$string['error_disabled'] = 'سبد خرید غیرفعال است.';
$string['error_coupon_disabled'] = 'کد تخفیف فعال نمی‌باشد.';
$string['error_coupon_apply_failed'] = 'کد تخفیف اعمال نشد.';
$string['error_coupon_is_invalid'] = 'کد تخفیف معتبر نمی‌باشد.';
$string['error_discount_type_is_invalid'] = 'نوع تخفیف معتبر نیست.';
$string['error_discount_amount_is_invalid'] = 'مقدار تخفیف معتبر نیست.';
$string['error_discount_amount_is_higher'] = 'مبلغ تخفیف نمی‌تواند از مبلغ اصلی بالاتر باشد.';
$string['error_discount_amount_must_be_a_number'] = 'مقدار تخفیف باید یک عدد باشد.';
$string['error_discount_amount_percentage_is_invalid'] = 'درصد تخفیف باید عدد صحیح و بین ۰ تا ۱۰۰ باشد.';
$string['error_gateway_is_invalid'] = 'درگاه انتخاب شده معتبر نیست.';
$string['error_coupon_class_not_found'] = 'کلاس کوپن تخفیف پیدا نشد.';
$string['error_coupon_class_not_implemented'] = 'کلاس کوپن تخفیف درست پیاده سازی نشده است.';

$string['msg_delivery_successful'] = 'ثبت نام شما در دوره (های) زیر با موفقیت انجام شد.';
$string['msg_delivery_filed'] = 'در روند ثبت نام شما مشکلی پیش آمد.';
$string['msg_instance_deleted'] = 'ثبت نام یکی از دوره‌ها پاک شده است.';
$string['msg_already_enrolled'] = 'شما قبلا در دوره "{$a->title}" ثبت نام کرده‌اید.';
$string['msg_cart_changed'] = 'آیتم(ها) یا مبلغ نهایی سبد خرید تغییر پیدا کرده است.';
$string['msg_cancel_successful'] = 'خرید شما لغو شد.';
$string['msg_cancel_filed'] = 'در لفو خرید شما مشکلی پیش‌ آمد.';
$string['msg_cart_cannot_be_edited'] = 'در حال حاضر امکان ویرایش یا تغییر در سبد خرید وجود ندارد.';
