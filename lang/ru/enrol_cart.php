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

$string['IRR'] = 'IRR';
$string['IRT'] = 'IRT';
$string['a_week'] = 'Неделя';
$string['add_to_cart'] = 'Добавить в корзину';
$string['add_to_group'] = 'Добавить в группу';
$string['apply'] = 'Применить';
$string['assign_role'] = 'Роль пользователя';
$string['assign_role_desc'] = 'Роль, назначаемая пользователям после оплаты и зачисления.';
$string['availability'] = 'Условия доступности';
$string['availability_help'] = 'Ограничьте, какие пользователи могут зачисляться через корзину, на основе условий доступности.';
$string['cancel'] = 'Отмена';
$string['cancel_cart'] = 'Отменить';
$string['canceled_cart_lifetime'] = 'Период хранения отменённых корзин';
$string['canceled_cart_lifetime_desc'] =
    'Отменённые корзины будут навсегда удалены после указанного периода. Значение 0 означает без ограничений.';

$string['cart:config'] = 'Настроить экземпляры зачисления через корзину';
$string['cart:manage'] = 'Управлять зачисленными пользователями';
$string['cart:unenrol'] = 'Отчислить пользователей с курса';
$string['cart:unenrolself'] = 'Отчислиться с курса';
$string['cart:view'] = 'Просмотр корзины';

$string['cart_is_empty'] = 'Ваша корзина пуста';
$string['cart_status'] = 'Статус';
$string['checkout'] = 'Оформление заказа';
$string['choose_gateway'] = 'Выберите платёжный шлюз:';
$string['complete_purchase'] = 'Завершить покупку';
$string['convert_irr_to_irt'] = 'Преобразовать IRR в Туман';
$string['convert_irr_to_irt_desc'] =
    'Если включено, суммы в иранских риалах будут преобразованы в туманы для отображения. <b>(Эта настройка влияет только на отображение; при создании или редактировании методов зачисления суммы должны указываться в риалах.)</b>';
$string['convert_numbers_to_persian'] = 'Преобразовывать английские цифры в персидские';
$string['convert_numbers_to_persian_desc'] =
    'Если включено, английские цифры будут преобразованы в персидские при отображении сумм.';
$string['cost'] = 'Стоимость';
$string['cost_help'] = 'Цена курса может начинаться с 0. Значение 0 означает, что курс бесплатный.';
$string['coupon_class'] = 'Класс купона на скидку';
$string['coupon_class_desc'] =
    'Укажите путь к классу купона. Пример: <code dir="ltr">local_coupon\object\coupon</code>. Класс купона должен реализовывать интерфейс <code dir="ltr">enrol_cart\local\object\coupon_interface</code>.';
$string['coupon_code'] = 'Код купона';
$string['coupon_discount'] = 'Скидка по купону';
$string['coupon_enable'] = 'Включить купоны на скидку';
$string['coupon_enable_desc'] =
    'Корзина поддерживает использование купонов, если установлен совместимый плагин купонов.';
$string['currency'] = 'Валюта';
$string['date'] = 'Дата';
$string['delete_expired_carts'] = 'Удалить просроченные корзины';
$string['discount'] = 'Скидка';
$string['discount_amount'] = 'Сумма скидки';
$string['discount_type'] = 'Тип скидки';
$string['enable_guest_cart'] = 'Разрешить гостям добавлять/удалять курсы из корзины';
$string['enable_guest_cart_desc'] =
    'Если включено, гости смогут добавлять курсы в корзину и удалять их при необходимости.';

$string['enrol_end_date'] = 'Дата окончания зачисления';
$string['enrol_end_date_help'] = 'Если включено, пользователи могут зачисляться до этой даты.';
$string['enrol_instance_defaults'] = 'Настройки по умолчанию для зачисления';
$string['enrol_instance_defaults_desc'] = 'Параметры по умолчанию для новых зачислений';
$string['enrol_period'] = 'Период зачисления';
$string['enrol_period_desc'] = 'Период, в течение которого пользователь остаётся зачисленным. Значение 0 — без ограничений.';
$string['enrol_period_help'] = 'Продолжительность зачисления после регистрации. Значение 0 — без ограничений.';
$string['enrol_start_date'] = 'Дата начала зачисления';
$string['enrol_start_date_help'] = 'Если включено, пользователи могут зачисляться с этой даты.';
$string['error_cost'] = 'Сумма должна быть числом.';
$string['error_coupon_apply_failed'] = 'Не удалось применить код скидки.';
$string['error_coupon_class_not_found'] = 'Класс купона не найден.';
$string['error_coupon_class_not_implemented'] = 'Класс купона реализован неправильно.';
$string['error_coupon_disabled'] = 'Купон отключён.';
$string['error_coupon_is_invalid'] = 'Неверный код купона.';
$string['error_disabled'] = 'Корзина отключена.';
$string['error_discount_amount_is_higher'] = 'Сумма скидки не может превышать исходную цену.';
$string['error_discount_amount_is_invalid'] = 'Недопустимая сумма скидки.';
$string['error_discount_amount_must_be_a_number'] = 'Сумма скидки должна быть числом.';
$string['error_discount_amount_percentage_is_invalid'] = 'Процент скидки должен быть целым числом от 0 до 100.';
$string['error_discount_type_is_invalid'] = 'Недопустимый тип скидки.';
$string['error_enrol_end_date'] = 'Дата окончания зачисления не может быть раньше даты начала.';
$string['error_gateway_is_invalid'] = 'Недопустимый платёжный шлюз.';
$string['error_group_is_invalid'] = 'Недопустимая группа.';
$string['error_invalid_cart'] = 'Недопустимая корзина.';
$string['error_no_payment_accounts_available'] = 'Нет доступных платёжных счетов.';
$string['error_no_payment_currency_available'] = 'Невозможно произвести оплату ни в одной валюте. Убедитесь, что активен хотя бы один платёжный шлюз.';
$string['error_no_payment_gateway_available'] = 'Нет доступных платёжных шлюзов. Укажите счёт и валюту перед выбором шлюза.';
$string['error_status_no_payment_account'] = 'Невозможно включить зачисление через корзину без указания платёжного счёта.';
$string['error_status_no_payment_currency'] = 'Невозможно включить зачисление через корзину без указания валюты платежа.';

$string['event_cart_deleted'] = 'Корзина очищена';
$string['fixed'] = 'Фиксированная сумма';
$string['free'] = 'Бесплатно';
$string['gateway_wait'] = 'Пожалуйста, подождите...';
$string['instructions'] = 'Инструкции на странице зачисления';

$string['msg_cart_cancel_failed'] = 'Возникла проблема с обработкой вашей корзины.';
$string['msg_cart_cancel_success'] = 'Ваша корзина была отменена.';
$string['msg_cart_changed'] = 'Товары или сумма оплаты в корзине были изменены.';
$string['msg_cart_edit_blocked'] = 'Редактирование корзины сейчас невозможно.';
$string['msg_enrolment_already'] = 'Вы уже зачислены на курс "{$a->title}".';
$string['msg_enrolment_deleted'] = 'Одно из зачислений на курс было удалено.';
$string['msg_enrolment_failed'] = 'Произошла ошибка при зачислении.';
$string['msg_enrolment_success'] = 'Ваше зачисление на указанные ниже курсы успешно завершено.';

$string['my_purchases'] = 'Мои покупки';
$string['never'] = 'Никогда';
$string['no_discount'] = 'Без скидки';
$string['no_items'] = 'Элементы не найдены.';
$string['not_delete_cart_with_payment_record'] = 'Не удалять корзины с записями об оплате';
$string['not_delete_cart_with_payment_record_desc'] = 'Если включено, корзины с записями в таблице платежей не будут удалены.';
$string['one_day'] = 'Один день';
$string['one_month'] = 'Один месяц';
$string['order'] = 'Заказ';
$string['order_id'] = 'ID заказа';
$string['pay'] = 'Оплатить';
$string['payable'] = 'К оплате';
$string['payment'] = 'Платёж';
$string['payment_account'] = 'Платёжный счёт';
$string['payment_account_help'] = 'Платежи будут зачислены на этот счёт.';
$string['payment_completion_time'] = 'Время завершения оплаты';
$string['payment_completion_time_desc'] =
    'Этот параметр определяет максимальное время, отведённое пользователю для завершения оплаты после её начала. В течение этого времени товары, сумма и скидка будут заблокированы.';
$string['payment_currency'] = 'Валюта платежа';
$string['pending_payment_cart_lifetime'] = 'Период хранения корзин с ожидающей оплатой';
$string['pending_payment_cart_lifetime_desc'] =
    'Корзины с ожидающей оплатой будут удалены после указанного периода. Значение 0 — без ограничений.';
$string['percentage'] = 'Процент';
$string['pluginname'] = 'Корзина покупок';
$string['pluginname_desc'] =
    'Метод зачисления через корзину создаёт общесайтовую корзину, позволяющую пользователям добавлять курсы и оплачивать их.';
$string['price'] = 'Цена';

$string['privacy:metadata:enrol_cart'] = 'Данные о корзинах, используемых для зачисления.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'Время оформления корзины.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'Код применённого купона, если есть.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'ID применённого купона, если есть.';
$string['privacy:metadata:enrol_cart:created_at'] = 'Время создания корзины.';
$string['privacy:metadata:enrol_cart:currency'] = 'Используемая валюта корзины.';
$string['privacy:metadata:enrol_cart:payable'] = 'Общая сумма к оплате.';
$string['privacy:metadata:enrol_cart:price'] = 'Общая цена корзины.';
$string['privacy:metadata:enrol_cart:status'] = 'Статус корзины (например, ожидает, завершена).';
$string['privacy:metadata:enrol_cart:user_id'] = 'ID пользователя, связанного с корзиной.';
$string['privacy:metadata:enrol_cart_items'] = 'Данные о товарах в корзине.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'ID корзины, содержащей товар.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'ID экземпляра зачисления, связанного с товаром.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'Сумма к оплате за товар.';
$string['privacy:metadata:enrol_cart_items:price'] = 'Цена товара.';
$string['privacy:metadata:reason'] = 'Плагин enrol_cart напрямую не хранит пользовательские данные.';

$string['proceed_to_checkout'] = 'Перейти к оформлению заказа';
$string['select_payment_method'] = 'Выберите способ оплаты';
$string['six_months'] = 'Шесть месяцев';
$string['status'] = 'Включить зачисление через корзину';
$string['status_canceled'] = 'Отменено';
$string['status_checkout'] = 'Оформление';
$string['status_current'] = 'Активно';
$string['status_delivered'] = 'Доставлено';
$string['status_desc'] = 'Позволяет пользователям добавлять курсы в корзину по умолчанию.';
$string['three_months'] = 'Три месяца';
$string['total'] = 'Итого';
$string['total_order_amount'] = 'Общая сумма';
$string['unknown'] = 'Неизвестно';
$string['unlimited'] = 'Без ограничений';
$string['user'] = 'Пользователь';
$string['verify_payment_on_delivery'] = 'Сверять окончательную сумму с оплатой при доставке';
$string['verify_payment_on_delivery_desc'] =
    'Если включено, окончательная сумма корзины будет сверяться с оплаченной суммой при доставке. Корзина будет доставлена только при совпадении сумм.';
$string['view'] = 'Просмотр';
