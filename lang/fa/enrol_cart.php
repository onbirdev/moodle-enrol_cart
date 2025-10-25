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

$string['IRR'] = 'ریال';
$string['IRT'] = 'تومان';
$string['a_week'] = 'یک هفته';
$string['add_to_cart'] = 'افزودن به سبد خرید';
$string['add_to_group'] = 'اضافه کردن به گروه';
$string['apply'] = 'ثبت';
$string['assign_role'] = 'نقش کاربر';
$string['assign_role_desc'] = 'نقشی که پس از پرداخت و ثبت‌نام به کاربر اختصاص داده می‌شود.';
$string['availability'] = 'شرایط دسترسی';
$string['availability_help'] = 'تعیین کنید کدام کاربران بر اساس شرایط دسترسی می‌توانند از این روش ثبت‌نام از طریق سبد خرید استفاده کنند.';
$string['cancel'] = 'لغو';
$string['cancel_cart'] = 'لغو خرید';
$string['canceled_cart_lifetime'] = 'مدت زمان نگهداری سبد خریدهای لغو شده';
$string['canceled_cart_lifetime_desc'] =
    'سبد خریدهای <b>لغو شده</b> پس از مدت زمان تعیین‌شده، به‌طور کامل حذف خواهند شد. مقدار صفر به معنی نامحدود است.';

$string['cart:config'] = 'پیکربندی ثبت نام سبد خرید';
$string['cart:manage'] = 'مدیریت کاربران ثبت نام شده';
$string['cart:unenrol'] = 'لغو ثبت نام کاربران دوره';
$string['cart:unenrolself'] = 'لغو ثبت نام من';
$string['cart:view'] = 'مشاهده سبد خرید';

$string['cart_is_empty'] = 'سبد خرید شما خالی است';
$string['cart_status'] = 'وضعیت';
$string['checkout'] = 'پرداخت';
$string['choose_gateway'] = 'انتخاب درگاه پرداخت:';
$string['complete_purchase'] = 'نهایی کردن خرید';
$string['convert_irr_to_irt'] = 'تبدیل ریال به تومان';
$string['convert_irr_to_irt_desc'] =
    'با انتخاب این گزینه، مبلغ‌های ریال ایران به واحد تومان تبدیل و نمایش داده می‌شوند. <b>(این تنظیم صرفاً در حالت نمایش مبلغ برای کاربر کاربرد دارد. هنگام ایجاد یا ویرایش روش ثبت‌نام، مبلغ باید همچنان به ریال وارد شود.)</b>';
$string['convert_numbers_to_persian'] = 'تبدیل اعداد انگلیسی به فارسی';
$string['convert_numbers_to_persian_desc'] =
    'با انتخاب این گزینه، در زمان نمایش مبلغ، اعداد انگلیسی به فارسی تبدیل خواهند شد.';
$string['cost'] = 'مبلغ';
$string['cost_help'] = 'مبلغ دوره می‌تواند از ۰ شروع شود. مقدار ۰ به‌معنای رایگان بودن دوره است.';
$string['coupon_class'] = 'کلاس کوپن تخفیف';
$string['coupon_class_desc'] =
    'مسیر کلاس کوپن تخفیف را مشخص کنید. مانند: <code dir="ltr">local_coupon\object\coupon</code> — کلاس کوپن تخفیف باید رابط <code dir="ltr">enrol_cart\local\object\coupon_interface</code> را پیاده‌سازی کند.';
$string['coupon_code'] = 'کد تخفیف';
$string['coupon_discount'] = 'تخفیف کوپن';
$string['coupon_enable'] = 'فعال بودن کوپن تخفیف';
$string['coupon_enable_desc'] =
    'سبد خرید از امکان استفاده از کوپن تخفیف پشتیبانی می‌کند. در صورتی که پلاگین کوپن تخفیف در سیستم نصب شده باشد، استفاده از آن در سبد خرید امکان‌پذیر خواهد بود.';
$string['currency'] = 'واحد پول';
$string['date'] = 'تاریخ';
$string['delete_expired_carts'] = 'حذف سبد خریدهای منقضی شده';
$string['discount'] = 'تخفیف';
$string['discount_amount'] = 'مقدار تخفیف';
$string['discount_type'] = 'نوع تخفیف';
$string['enable_guest_cart'] = 'اجازه به مهمان‌ها برای افزودن و حذف دوره از سبد خرید';
$string['enable_guest_cart_desc'] =
    'در صورت فعال بودن این گزینه، کاربران مهمان می‌توانند دوره‌ها را به سبد خرید اضافه کرده و در صورت نیاز آن‌ها را حذف کنند.';

$string['enrol_end_date'] = 'تاریخ پایان ثبت‌نام';
$string['enrol_end_date_help'] = 'در صورت فعال بودن، کاربران فقط تا این تاریخ می‌توانند ثبت‌نام کنند.';
$string['enrol_instance_defaults'] = 'پیش‌فرض‌های ثبت‌نام';
$string['enrol_instance_defaults_desc'] = 'تنظیمات پیش‌فرض مربوط به ثبت‌نام در درس‌های جدید';
$string['enrol_period'] = 'مدت ثبت‌نام';
$string['enrol_period_desc'] = 'مدت زمانی که کاربر در دوره ثبت‌نام باقی می‌ماند. مقدار ۰ به‌معنای نامحدود است.';
$string['enrol_period_help'] = 'مدت اعتبار ثبت‌نام کاربر در دوره که از زمان ثبت‌نام شروع می‌شود. مقدار ۰ به‌معنای نامحدود است.';
$string['enrol_start_date'] = 'تاریخ شروع ثبت‌نام';
$string['enrol_start_date_help'] = 'در صورت فعال بودن، کاربران از این تاریخ به بعد می‌توانند ثبت‌نام کنند.';

$string['error_cost'] = 'مبلغ باید یک عدد باشد.';
$string['error_coupon_apply_failed'] = 'اعمال کد تخفیف با شکست مواجه شد.';
$string['error_coupon_class_not_found'] = 'کلاس کوپن تخفیف پیدا نشد.';
$string['error_coupon_class_not_implemented'] = 'کلاس کوپن تخفیف به‌درستی پیاده‌سازی نشده است.';
$string['error_coupon_disabled'] = 'کد تخفیف غیرفعال است.';
$string['error_coupon_is_invalid'] = 'کد تخفیف نامعتبر است.';
$string['error_disabled'] = 'سبد خرید غیرفعال است.';
$string['error_discount_amount_is_higher'] = 'مقدار تخفیف نمی‌تواند از مبلغ اصلی بیشتر باشد.';
$string['error_discount_amount_is_invalid'] = 'مقدار تخفیف نامعتبر است.';
$string['error_discount_amount_must_be_a_number'] = 'مقدار تخفیف باید یک عدد باشد.';
$string['error_discount_amount_percentage_is_invalid'] = 'درصد تخفیف باید عددی صحیح بین ۰ تا ۱۰۰ باشد.';
$string['error_discount_type_is_invalid'] = 'نوع تخفیف نامعتبر است.';
$string['error_enrol_end_date'] = 'تاریخ پایان ثبت‌نام نمی‌تواند پیش از تاریخ شروع باشد.';
$string['error_gateway_is_invalid'] = 'درگاه پرداخت انتخاب‌شده نامعتبر است.';
$string['error_group_is_invalid'] = 'گروه نامعتبر است.';
$string['error_invalid_cart'] = 'سبد خرید نامعتبر است.';
$string['error_no_payment_accounts_available'] = 'هیچ حساب پرداختی موجود نیست.';
$string['error_no_payment_currency_available'] =
    'امکان پرداخت با هیچ واحد پولی وجود ندارد. لطفاً مطمئن شوید که حداقل یک درگاه پرداخت فعال است.';
$string['error_no_payment_gateway_available'] =
    'هیچ درگاه پرداختی در دسترس نیست. لطفاً برای انتخاب درگاه پرداخت، ابتدا حساب پرداخت و واحد پول را مشخص کنید.';
$string['error_status_no_payment_account'] = 'فعال‌سازی روش ثبت‌نام سبد خرید بدون مشخص کردن حساب پرداخت ممکن نیست.';
$string['error_status_no_payment_currency'] = 'فعال‌سازی روش ثبت‌نام سبد خرید بدون مشخص کردن واحد پول ممکن نیست.';

$string['event_cart_deleted'] = 'سبد خرید حذف شد';
$string['fixed'] = 'مبلغ ثابت';
$string['free'] = 'رایگان';
$string['gateway_wait'] = 'درحال اتصال به درگاه پرداخت ...';
$string['instructions'] = 'دستورالعمل صفحه ثبت‌نام';

$string['msg_cart_cancel_failed'] = 'در لغو سبد خرید شما مشکلی پیش آمد.';
$string['msg_cart_cancel_success'] = 'سبد خرید شما با موفقیت لغو شد.';
$string['msg_cart_changed'] = 'آیتم‌ها یا مبلغ نهایی سبد خرید تغییر کرده‌اند.';
$string['msg_cart_edit_blocked'] = 'در حال حاضر امکان ویرایش یا تغییر سبد خرید وجود ندارد.';
$string['msg_enrolment_already'] = 'شما قبلاً در دوره «{$a->title}» ثبت‌نام کرده‌اید.';
$string['msg_enrolment_deleted'] = 'روش ثبت‌نام یکی از دوره‌ها حذف شده است.';
$string['msg_enrolment_failed'] = 'در روند ثبت‌نام شما مشکلی پیش آمد.';
$string['msg_enrolment_success'] = 'ثبت‌نام شما در دوره(های) زیر با موفقیت انجام شد.';

$string['my_purchases'] = 'خرید‌های من';
$string['never'] = 'هیچ وقت';
$string['no_discount'] = 'بدون تخفیف';
$string['no_items'] = 'آیتمی پیدا نشد.';
$string['not_delete_cart_with_payment_record'] = 'عدم حذف سبد خریدهای دارای رکورد پرداخت';
$string['not_delete_cart_with_payment_record_desc'] =
    'در صورت انتخاب این گزینه، سبد خریدهایی که دارای رکورد در جدول پرداخت (payment) هستند حذف نخواهند شد.';
$string['one_day'] = 'یک روز';
$string['one_month'] = 'یک ماه';
$string['order'] = 'خرید';
$string['order_id'] = 'کد خرید';
$string['pay'] = 'پرداخت';
$string['payable'] = 'قابل پرداخت';
$string['payment'] = 'پرداخت';
$string['payment_account'] = 'حساب پرداخت';
$string['payment_account_help'] = 'مبالغ پرداخت‌شده به این حساب واریز خواهند شد.';
$string['payment_completion_time'] = 'مدت زمان تکمیل پرداخت';
$string['payment_completion_time_desc'] =
    'این متغیر مشخص می‌کند که کاربر پس از اقدام به پرداخت، حداکثر تا چه مدت می‌تواند پرداخت خود را کامل کند. در این مدت، آیتم‌ها، مبلغ سبد خرید و کد تخفیف برای پرداخت کاربر قفل خواهند شد.';
$string['payment_currency'] = 'واحد پول';
$string['pending_payment_cart_lifetime'] = 'مدت زمان نگهداری سبد خریدهای در انتظار پرداخت';
$string['pending_payment_cart_lifetime_desc'] =
    'سبد خریدهای <b>در انتظار پرداخت</b> پس از مدت زمان تعیین‌شده، به‌طور کامل حذف خواهند شد. مقدار صفر به معنی نامحدود است.';
$string['percentage'] = 'درصد';
$string['pluginname'] = 'سبد خرید';
$string['pluginname_desc'] =
    'روش ثبت‌نام با سبد خرید، سبد خریدی در سطح سایت ایجاد می‌کند که به کاربران این امکان را می‌دهد تا دوره‌ها را به سبد خرید اضافه کرده و آن‌ها را خریداری کنند.';
$string['price'] = 'مبلغ';

$string['privacy:metadata:enrol_cart'] = 'جزئیات مربوط به سبدهای خرید مورد استفاده برای ثبت‌نام.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'زمانی که سبد خرید تسویه شده است.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'کد تخفیف اعمال شده روی سبد خرید، در صورت وجود.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'شناسه کد تخفیف اعمال شده روی سبد خرید، در صورت وجود.';
$string['privacy:metadata:enrol_cart:created_at'] = 'زمانی که سبد خرید ایجاد شده است.';
$string['privacy:metadata:enrol_cart:currency'] = 'واحد پولی مورد استفاده در این سبد خرید.';
$string['privacy:metadata:enrol_cart:payable'] = 'مبلغ قابل پرداخت در سبد خرید.';
$string['privacy:metadata:enrol_cart:price'] = 'قیمت کل سبد خرید.';
$string['privacy:metadata:enrol_cart:status'] = 'وضعیت سبد خرید (مانند در انتظار، تکمیل‌شده).';
$string['privacy:metadata:enrol_cart:user_id'] = 'شناسه کاربری مرتبط با این سبد خرید.';
$string['privacy:metadata:enrol_cart_items'] = 'جزئیات آیتم‌های موجود در یک سبد خرید.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'شناسه سبد خرید حاوی این آیتم.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'شناسه مورد ثبت‌نام مرتبط با این آیتم.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'مبلغ قابل پرداخت برای آیتم.';
$string['privacy:metadata:enrol_cart_items:price'] = 'قیمت آیتم.';
$string['privacy:metadata:reason'] = 'افزونه enrol_cart به طور مستقیم هیچ اطلاعات کاربری را ذخیره نمی‌کند.';

$string['proceed_to_checkout'] = 'تایید و تکمیل خرید';
$string['select_payment_method'] = 'انتخاب روش پرداخت';
$string['six_months'] = 'شش ماه';
$string['status'] = 'فعال‌سازی ثبت‌نام با سبد خرید';
$string['status_canceled'] = 'لغو شده';
$string['status_checkout'] = 'در انتظار پرداخت';
$string['status_current'] = 'فعال';
$string['status_delivered'] = 'تحویل شده';
$string['status_desc'] = 'به کاربران اجازه می‌دهد دوره‌ها را به صورت پیش‌فرض به سبد خرید اضافه کنند.';
$string['three_months'] = 'سه ماه';
$string['total'] = 'جمع کل';
$string['total_order_amount'] = 'جمع خرید';
$string['unknown'] = 'نامشخص';
$string['unlimited'] = 'نامحدود';
$string['user'] = 'کاربر';
$string['verify_payment_on_delivery'] = 'مطابقت مبلغ نهایی با پرداخت هنگام تحویل';
$string['verify_payment_on_delivery_desc'] =
    'با انتخاب این گزینه، هنگام تحویل سبد خرید، مبلغ نهایی با مبلغ پرداخت‌شده مقایسه می‌شود و تنها در صورت برابر بودن، سبد خرید تحویل داده خواهد شد.';
$string['view'] = 'مشاهده';
