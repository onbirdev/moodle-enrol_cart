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

$string['IRR'] = '伊朗里亚尔';
$string['IRT'] = '托曼';
$string['a_week'] = '一周';
$string['add_to_cart'] = '加入购物车';
$string['add_to_group'] = '加入群组';
$string['apply'] = '应用';
$string['assign_role'] = '用户角色';
$string['assign_role_desc'] = '支付并注册后分配给用户的角色。';
$string['availability'] = '可用性条件';
$string['availability_help'] = '根据可用性条件限制哪些用户可以通过购物车注册。';
$string['cancel'] = '取消';
$string['cancel_cart'] = '取消';
$string['canceled_cart_lifetime'] = '已取消购物车保留期';
$string['canceled_cart_lifetime_desc'] = '在指定期限后，已取消的购物车将被永久删除。值为0表示无限期保留。';

$string['cart:config'] = '配置购物车注册实例';
$string['cart:manage'] = '管理已注册用户';
$string['cart:unenrol'] = '从课程中取消用户注册';
$string['cart:unenrolself'] = '自行从课程中取消注册';
$string['cart:view'] = '查看购物车';

$string['cart_is_empty'] = '您的购物车是空的';
$string['cart_status'] = '状态';
$string['checkout'] = '结账';
$string['choose_gateway'] = '选择支付网关：';
$string['complete_purchase'] = '完成购买';
$string['convert_irr_to_irt'] = '将里亚尔转换为托曼';
$string['convert_irr_to_irt_desc'] =
    '如果启用，伊朗里亚尔金额将在显示时转换为托曼。<b>（此设置仅影响显示效果；在创建或编辑注册方式时，金额仍需以里亚尔输入。）</b>';
$string['convert_numbers_to_persian'] = '将英文数字转换为波斯数字';
$string['convert_numbers_to_persian_desc'] = '如果启用，显示金额时英文数字将转换为波斯数字。';
$string['cost'] = '费用';
$string['cost_help'] = '课程价格可以从0开始，值为0表示课程免费。';
$string['coupon_class'] = '优惠券类';
$string['coupon_class_desc'] = '指定优惠券类的路径。例如：<code dir="ltr">local_coupon\object\coupon</code>。该类必须实现 <code dir="ltr">enrol_cart\local\object\coupon_interface</code> 接口。';
$string['coupon_code'] = '优惠码';
$string['coupon_discount'] = '优惠折扣';
$string['coupon_enable'] = '启用优惠券';
$string['coupon_enable_desc'] = '如果系统中安装了兼容的优惠券插件，购物车将支持使用优惠券。';
$string['currency'] = '货币';
$string['date'] = '日期';
$string['delete_expired_carts'] = '删除过期购物车';
$string['discount'] = '折扣';
$string['discount_amount'] = '折扣金额';
$string['discount_type'] = '折扣类型';
$string['enable_guest_cart'] = '允许访客添加/移除购物车中的课程';
$string['enable_guest_cart_desc'] = '如果启用，访客用户可以将课程添加到购物车或从中移除。';

$string['enrol_end_date'] = '注册结束日期';
$string['enrol_end_date_help'] = '启用后，用户可在此日期之前注册。';
$string['enrol_instance_defaults'] = '注册默认值';
$string['enrol_instance_defaults_desc'] = '用于新课程注册的默认设置';
$string['enrol_period'] = '注册时长';
$string['enrol_period_desc'] = '用户在课程中的注册持续时间。值为0表示无限期。';
$string['enrol_period_help'] = '注册后用户在课程中的持续时间。值为0表示无限期。';
$string['enrol_start_date'] = '注册开始日期';
$string['enrol_start_date_help'] = '启用后，用户可从此日期开始注册。';
$string['error_cost'] = '金额必须是数字。';
$string['error_coupon_apply_failed'] = '无法应用优惠码。';
$string['error_coupon_class_not_found'] = '未找到优惠券类。';
$string['error_coupon_class_not_implemented'] = '优惠券类未正确实现。';
$string['error_coupon_disabled'] = '优惠码已禁用。';
$string['error_coupon_is_invalid'] = '优惠码无效。';
$string['error_disabled'] = '购物车已禁用。';
$string['error_discount_amount_is_higher'] = '折扣金额不能超过原价。';
$string['error_discount_amount_is_invalid'] = '折扣金额无效。';
$string['error_discount_amount_must_be_a_number'] = '折扣金额必须是数字。';
$string['error_discount_amount_percentage_is_invalid'] = '折扣百分比必须是0到100之间的整数。';
$string['error_discount_type_is_invalid'] = '折扣类型无效。';
$string['error_enrol_end_date'] = '注册结束日期不能早于开始日期。';
$string['error_gateway_is_invalid'] = '所选支付网关无效。';
$string['error_group_is_invalid'] = '群组无效。';
$string['error_invalid_cart'] = '购物车无效。';
$string['error_no_payment_accounts_available'] = '没有可用的支付账户。';
$string['error_no_payment_currency_available'] = '无法使用任何货币进行支付。请确保至少启用了一个支付网关。';
$string['error_no_payment_gateway_available'] = '没有可用的支付网关。请在选择网关前指定支付账户和货币。';
$string['error_status_no_payment_account'] = '未指定支付账户时，无法启用购物车注册。';
$string['error_status_no_payment_currency'] = '未指定支付货币时，无法启用购物车注册。';

$string['event_cart_deleted'] = '购物车已清空';
$string['fixed'] = '固定金额';
$string['free'] = '免费';
$string['gateway_wait'] = '请稍候...';
$string['instructions'] = '注册页面说明';

$string['msg_cart_cancel_failed'] = '处理购物车时出现问题。';
$string['msg_cart_cancel_success'] = '您的购物车已取消。';
$string['msg_cart_changed'] = '购物车中的项目或应付金额已更改。';
$string['msg_cart_edit_blocked'] = '当前无法编辑或更改购物车。';
$string['msg_enrolment_already'] = '您已注册课程“{$a->title}”。';
$string['msg_enrolment_deleted'] = '已删除其中一个课程注册。';
$string['msg_enrolment_failed'] = '注册过程中出现问题。';
$string['msg_enrolment_success'] = '您已成功注册以下课程。';

$string['my_purchases'] = '我的购买';
$string['never'] = '从不';
$string['no_discount'] = '无折扣';
$string['no_items'] = '未找到任何项目。';
$string['not_delete_cart_with_payment_record'] = '不要删除含有支付记录的购物车';
$string['not_delete_cart_with_payment_record_desc'] = '如果启用，包含支付记录的购物车将不会被删除。';
$string['one_day'] = '一天';
$string['one_month'] = '一个月';
$string['order'] = '订单';
$string['order_id'] = '订单编号';
$string['pay'] = '支付';
$string['payable'] = '应付款';
$string['payment'] = '支付';
$string['payment_account'] = '支付账户';
$string['payment_account_help'] = '支付款项将存入此账户。';
$string['payment_completion_time'] = '支付完成时间';
$string['payment_completion_time_desc'] = '此设置定义用户发起支付后可完成支付的最长时间。在此期间，购物车项目、金额及任何优惠码将被锁定。';
$string['payment_currency'] = '货币单位';
$string['pending_payment_cart_lifetime'] = '待支付购物车保留期';
$string['pending_payment_cart_lifetime_desc'] = '在指定期限后，待支付的购物车将被永久删除。值为0表示无限期。';
$string['percentage'] = '百分比';
$string['pluginname'] = '购物车';
$string['pluginname_desc'] = '购物车注册方法创建一个全站购物系统，允许用户将课程加入购物车并购买。';
$string['price'] = '价格';

$string['privacy:metadata:enrol_cart'] = '注册所使用购物车的详细信息。';
$string['privacy:metadata:enrol_cart:checkout_at'] = '购物车结账的时间戳。';
$string['privacy:metadata:enrol_cart:coupon_code'] = '应用的优惠码（如有）。';
$string['privacy:metadata:enrol_cart:coupon_id'] = '应用的优惠券ID（如有）。';
$string['privacy:metadata:enrol_cart:created_at'] = '购物车创建的时间戳。';
$string['privacy:metadata:enrol_cart:currency'] = '购物车使用的货币。';
$string['privacy:metadata:enrol_cart:payable'] = '购物车应付总金额。';
$string['privacy:metadata:enrol_cart:price'] = '购物车总价格。';
$string['privacy:metadata:enrol_cart:status'] = '购物车状态（如：待处理、已完成）。';
$string['privacy:metadata:enrol_cart:user_id'] = '与购物车关联的用户ID。';
$string['privacy:metadata:enrol_cart_items'] = '购物车中项目的详细信息。';
$string['privacy:metadata:enrol_cart_items:cart_id'] = '包含该项目的购物车ID。';
$string['privacy:metadata:enrol_cart_items:instance_id'] = '与项目关联的注册实例ID。';
$string['privacy:metadata:enrol_cart_items:payable'] = '项目的应付金额。';
$string['privacy:metadata:enrol_cart_items:price'] = '项目价格。';
$string['privacy:metadata:reason'] = 'enrol_cart 插件不会直接存储任何用户数据。';

$string['proceed_to_checkout'] = '前往结账';
$string['select_payment_method'] = '选择支付方式';
$string['six_months'] = '六个月';
$string['status'] = '启用通过购物车注册';
$string['status_canceled'] = '已取消';
$string['status_checkout'] = '结账中';
$string['status_current'] = '当前活动';
$string['status_delivered'] = '已交付';
$string['status_desc'] = '默认允许用户将课程添加到购物车。';
$string['three_months'] = '三个月';
$string['total'] = '总计';
$string['total_order_amount'] = '订单总金额';
$string['unknown'] = '未知';
$string['unlimited'] = '无限制';
$string['user'] = '用户';
$string['verify_payment_on_delivery'] = '交付时验证最终支付金额';
$string['verify_payment_on_delivery_desc'] = '如果启用，将在交付时验证支付金额是否与购物车最终金额一致。只有金额匹配时才会交付。';
$string['view'] = '查看';
