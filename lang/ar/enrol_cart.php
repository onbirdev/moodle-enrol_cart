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

$string['IRR'] = 'ريال إيراني';
$string['IRT'] = 'تومان';
$string['a_week'] = 'أسبوع واحد';
$string['add_to_cart'] = 'أضف إلى السلة';
$string['add_to_group'] = 'أضف إلى المجموعة';
$string['apply'] = 'تطبيق';
$string['assign_role'] = 'دور المستخدم';
$string['assign_role_desc'] = 'الدور الذي يُمنح للمستخدمين بعد الدفع والتسجيل.';
$string['availability'] = 'شروط التوفر';
$string['availability_help'] = 'تقييد المستخدمين الذين يمكنهم التسجيل عبر السلة بناءً على شروط التوفر.';
$string['cancel'] = 'إلغاء';
$string['cancel_cart'] = 'إلغاء السلة';
$string['canceled_cart_lifetime'] = 'مدة الاحتفاظ بالسلال الملغاة';
$string['canceled_cart_lifetime_desc'] =
    'سيتم حذف السلال الملغاة نهائيًا بعد المدة المحددة. القيمة صفر تعني غير محددة.';

$string['cart:config'] = 'تكوين مثيلات التسجيل عبر السلة';
$string['cart:manage'] = 'إدارة المستخدمين المسجلين';
$string['cart:unenrol'] = 'إلغاء تسجيل المستخدمين من المقرر';
$string['cart:unenrolself'] = 'إلغاء تسجيل نفسك من المقرر';
$string['cart:view'] = 'عرض سلة التسوق';

$string['cart_is_empty'] = 'سلتك فارغة';
$string['cart_status'] = 'الحالة';
$string['checkout'] = 'الدفع';
$string['choose_gateway'] = 'اختر بوابة الدفع:';
$string['complete_purchase'] = 'إتمام الشراء';
$string['convert_irr_to_irt'] = 'تحويل الريال إلى تومان';
$string['convert_irr_to_irt_desc'] =
    'عند التفعيل، سيتم تحويل المبالغ بالريال الإيراني إلى تومان لأغراض العرض فقط. <b>(هذا الإعداد يؤثر فقط على طريقة عرض المبلغ للمستخدمين؛ يجب إدخال المبالغ بالريال عند إنشاء أو تعديل طرق التسجيل.)</b>';
$string['convert_numbers_to_persian'] = 'تحويل الأرقام الإنجليزية إلى فارسية';
$string['convert_numbers_to_persian_desc'] =
    'عند التفعيل، سيتم عرض الأرقام الإنجليزية بالأرقام الفارسية عند عرض المبالغ.';
$string['cost'] = 'التكلفة';
$string['cost_help'] = 'يمكن أن يبدأ سعر المقرر من 0. القيمة 0 تعني أن المقرر مجاني.';
$string['coupon_class'] = 'فئة قسيمة الخصم';
$string['coupon_class_desc'] =
    'حدد مسار الفئة الخاصة بقسيمة الخصم. مثال: <code dir="ltr">local_coupon\object\coupon</code>. يجب أن تطبق فئة القسيمة <code dir="ltr">enrol_cart\local\object\coupon_interface</code>.';
$string['coupon_code'] = 'رمز القسيمة';
$string['coupon_discount'] = 'خصم القسيمة';
$string['coupon_enable'] = 'تفعيل قسائم الخصم';
$string['coupon_enable_desc'] =
    'تدعم السلة استخدام قسائم الخصم إذا تم تثبيت مكون إضافي متوافق لذلك.';
$string['currency'] = 'العملة';
$string['date'] = 'التاريخ';
$string['delete_expired_carts'] = 'حذف السلال المنتهية الصلاحية';
$string['discount'] = 'الخصم';
$string['discount_amount'] = 'قيمة الخصم';
$string['discount_type'] = 'نوع الخصم';
$string['enable_guest_cart'] = 'السماح للزوار بإضافة/إزالة المقررات من السلة';
$string['enable_guest_cart_desc'] =
    'عند التفعيل، يمكن للمستخدمين الزوار إضافة المقررات إلى سلة التسوق أو إزالتها.';

$string['enrol_end_date'] = 'تاريخ انتهاء التسجيل';
$string['enrol_end_date_help'] = 'عند التفعيل، يمكن للمستخدمين التسجيل حتى هذا التاريخ.';
$string['enrol_instance_defaults'] = 'الإعدادات الافتراضية للتسجيل';
$string['enrol_instance_defaults_desc'] = 'الإعدادات الافتراضية للتسجيل في المقررات الجديدة';
$string['enrol_period'] = 'مدة التسجيل';
$string['enrol_period_desc'] = 'المدة التي يظل فيها المستخدم مسجلاً في المقرر. القيمة صفر تعني غير محددة.';
$string['enrol_period_help'] = 'المدة الزمنية بعد تسجيل المستخدم. القيمة صفر تعني غير محددة.';
$string['enrol_start_date'] = 'تاريخ بدء التسجيل';
$string['enrol_start_date_help'] = 'عند التفعيل، يمكن للمستخدمين التسجيل بدءًا من هذا التاريخ.';
$string['error_cost'] = 'يجب أن يكون المبلغ رقمًا.';
$string['error_coupon_apply_failed'] = 'فشل تطبيق رمز الخصم.';
$string['error_coupon_class_not_found'] = 'لم يتم العثور على فئة قسيمة الخصم.';
$string['error_coupon_class_not_implemented'] = 'فئة قسيمة الخصم غير مطبقة بشكل صحيح.';
$string['error_coupon_disabled'] = 'رمز الخصم معطل.';
$string['error_coupon_is_invalid'] = 'رمز الخصم غير صالح.';
$string['error_disabled'] = 'السلة معطلة.';
$string['error_discount_amount_is_higher'] = 'لا يمكن أن يتجاوز الخصم السعر الأصلي.';
$string['error_discount_amount_is_invalid'] = 'مبلغ الخصم غير صالح.';
$string['error_discount_amount_must_be_a_number'] = 'يجب أن يكون مبلغ الخصم رقمًا.';
$string['error_discount_amount_percentage_is_invalid'] = 'يجب أن تكون نسبة الخصم عددًا صحيحًا بين 0 و100.';
$string['error_discount_type_is_invalid'] = 'نوع الخصم غير صالح.';
$string['error_enrol_end_date'] = 'لا يمكن أن يكون تاريخ انتهاء التسجيل قبل تاريخ البدء.';
$string['error_gateway_is_invalid'] = 'بوابة الدفع المحددة غير صالحة.';
$string['error_group_is_invalid'] = 'المجموعة غير صالحة.';
$string['error_invalid_cart'] = 'السلة غير صالحة.';
$string['error_no_payment_accounts_available'] = 'لا يوجد حساب دفع متاح.';
$string['error_no_payment_currency_available'] = 'لا يمكن إجراء الدفع بأي عملة. تأكد من تفعيل بوابة دفع واحدة على الأقل.';
$string['error_no_payment_gateway_available'] = 'لا توجد بوابة دفع متاحة. يرجى تحديد كل من الحساب والعملة قبل اختيار البوابة.';
$string['error_status_no_payment_account'] = 'لا يمكن تفعيل التسجيل عبر السلة دون تحديد حساب دفع.';
$string['error_status_no_payment_currency'] = 'لا يمكن تفعيل التسجيل عبر السلة دون تحديد عملة الدفع.';

$string['event_cart_deleted'] = 'تم مسح السلة';
$string['fixed'] = 'مبلغ ثابت';
$string['free'] = 'مجاني';
$string['gateway_wait'] = 'يرجى الانتظار...';
$string['instructions'] = 'تعليمات صفحة التسجيل';

$string['msg_cart_cancel_failed'] = 'حدثت مشكلة في عملية السلة.';
$string['msg_cart_cancel_success'] = 'تم إلغاء سلتك بنجاح.';
$string['msg_cart_changed'] = 'تم تغيير العناصر أو المبلغ القابل للدفع في السلة.';
$string['msg_cart_edit_blocked'] = 'لا يمكن تعديل السلة حاليًا.';
$string['msg_enrolment_already'] = 'أنت مسجل بالفعل في المقرر "{$a->title}".';
$string['msg_enrolment_deleted'] = 'تم حذف تسجيل أحد المقررات.';
$string['msg_enrolment_failed'] = 'حدثت مشكلة في عملية التسجيل.';
$string['msg_enrolment_success'] = 'تم إتمام تسجيلك في المقررات التالية بنجاح.';

$string['my_purchases'] = 'مشترياتي';
$string['never'] = 'أبدًا';
$string['no_discount'] = 'بدون خصم';
$string['no_items'] = 'لم يتم العثور على عناصر.';
$string['not_delete_cart_with_payment_record'] = 'عدم حذف السلال التي تحتوي على سجلات دفع';
$string['not_delete_cart_with_payment_record_desc'] = 'عند التفعيل، لن يتم حذف السلال التي تحتوي على سجلات في جدول المدفوعات.';
$string['one_day'] = 'يوم واحد';
$string['one_month'] = 'شهر واحد';
$string['order'] = 'طلب';
$string['order_id'] = 'معرّف الطلب';
$string['pay'] = 'ادفع';
$string['payable'] = 'المبلغ المستحق';
$string['payment'] = 'الدفع';
$string['payment_account'] = 'حساب الدفع';
$string['payment_account_help'] = 'ستُودع المدفوعات في هذا الحساب.';
$string['payment_completion_time'] = 'مدة إتمام الدفع';
$string['payment_completion_time_desc'] =
    'يحدد هذا الإعداد أقصى مدة مسموح بها لإتمام عملية الدفع بعد بدئها. خلال هذه المدة سيتم قفل العناصر والمبلغ وأي رمز خصم.';
$string['payment_currency'] = 'وحدة العملة';
$string['pending_payment_cart_lifetime'] = 'مدة الاحتفاظ بالسلال قيد الدفع';
$string['pending_payment_cart_lifetime_desc'] =
    'سيتم حذف السلال التي لم تكتمل عملية الدفع فيها بعد المدة المحددة. القيمة صفر تعني غير محددة.';
$string['percentage'] = 'نسبة مئوية';
$string['pluginname'] = 'سلة التسوق';
$string['pluginname_desc'] =
    'تسمح طريقة التسجيل عبر سلة التسوق للمستخدمين بإضافة المقررات إلى سلة مشتركة على مستوى الموقع وشرائها.';
$string['price'] = 'السعر';

$string['privacy:metadata:enrol_cart'] = 'تفاصيل سلال التسوق المستخدمة للتسجيل.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'الوقت الذي تم فيه تنفيذ الدفع.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'رمز القسيمة المطبق، إن وُجد.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'معرّف القسيمة المطبقة، إن وُجد.';
$string['privacy:metadata:enrol_cart:created_at'] = 'وقت إنشاء السلة.';
$string['privacy:metadata:enrol_cart:currency'] = 'العملة المستخدمة في السلة.';
$string['privacy:metadata:enrol_cart:payable'] = 'إجمالي المبلغ المستحق في السلة.';
$string['privacy:metadata:enrol_cart:price'] = 'إجمالي سعر السلة.';
$string['privacy:metadata:enrol_cart:status'] = 'حالة السلة (مثل قيد التنفيذ، مكتمل، إلخ).';
$string['privacy:metadata:enrol_cart:user_id'] = 'معرّف المستخدم المرتبط بالسلة.';
$string['privacy:metadata:enrol_cart_items'] = 'تفاصيل العناصر في سلة التسوق.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'معرّف السلة التي تحتوي على العنصر.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'معرّف مثيل التسجيل المرتبط بالعنصر.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'المبلغ المستحق للعنصر.';
$string['privacy:metadata:enrol_cart_items:price'] = 'سعر العنصر.';
$string['privacy:metadata:reason'] = 'المكون الإضافي enrol_cart لا يخزن أي بيانات مستخدم مباشرة.';

$string['proceed_to_checkout'] = 'المتابعة إلى الدفع';
$string['select_payment_method'] = 'اختر طريقة الدفع';
$string['six_months'] = 'ستة أشهر';
$string['status'] = 'تفعيل التسجيل عبر سلة التسوق';
$string['status_canceled'] = 'ملغاة';
$string['status_checkout'] = 'قيد الدفع';
$string['status_current'] = 'نشطة حاليًا';
$string['status_delivered'] = 'مكتملة';
$string['status_desc'] = 'يسمح للمستخدمين بإضافة المقررات إلى السلة بشكل افتراضي.';
$string['three_months'] = 'ثلاثة أشهر';
$string['total'] = 'الإجمالي';
$string['total_order_amount'] = 'إجمالي المبلغ';
$string['unknown'] = 'غير معروف';
$string['unlimited'] = 'غير محدود';
$string['user'] = 'المستخدم';
$string['verify_payment_on_delivery'] = 'مطابقة المبلغ النهائي مع الدفع عند التسليم';
$string['verify_payment_on_delivery_desc'] =
    'عند التفعيل، سيتم مقارنة المبلغ النهائي للسلة بالمبلغ المدفوع عند التسليم، ولن تُسلّم السلة إلا إذا كانت القيم متطابقة.';
$string['view'] = 'عرض';
