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
$string['a_week'] = 'Una semana';
$string['add_to_cart'] = 'Agregar al carrito';
$string['add_to_group'] = 'Agregar al grupo';
$string['apply'] = 'Aplicar';
$string['assign_role'] = 'Rol de usuario';
$string['assign_role_desc'] = 'El rol asignado a los usuarios después del pago y la inscripción.';
$string['availability'] = 'Condiciones de disponibilidad';
$string['availability_help'] = 'Restringe qué usuarios pueden inscribirse mediante el carrito según las condiciones de disponibilidad.';
$string['cancel'] = 'Cancelar';
$string['cancel_cart'] = 'Cancelar';
$string['canceled_cart_lifetime'] = 'Periodo de retención de carritos cancelados';
$string['canceled_cart_lifetime_desc'] =
    'Los carritos cancelados se eliminarán permanentemente después del período especificado. Un valor de cero significa ilimitado.';

$string['cart:config'] = 'Configurar instancias de inscripción del carrito';
$string['cart:manage'] = 'Gestionar usuarios inscritos';
$string['cart:unenrol'] = 'Desinscribir usuarios del curso';
$string['cart:unenrolself'] = 'Desinscribirse del curso';
$string['cart:view'] = 'Ver carrito de compras';

$string['cart_is_empty'] = 'Tu carrito está vacío';
$string['cart_status'] = 'Estado';
$string['checkout'] = 'Pagar';
$string['choose_gateway'] = 'Elige la pasarela de pago:';
$string['complete_purchase'] = 'Completar compra';
$string['convert_irr_to_irt'] = 'Convertir IRR a Toman';
$string['convert_irr_to_irt_desc'] =
    'Si está habilitado, los montos en Rial iraní se convertirán a Toman solo para fines de visualización. <b>(Esta configuración solo afecta cómo se muestra el monto a los usuarios; al crear o editar métodos de inscripción, los montos deben ingresarse en Rial.)</b>';
$string['convert_numbers_to_persian'] = 'Convertir números ingleses a persas';
$string['convert_numbers_to_persian_desc'] =
    'Si está habilitado, los números en inglés se convertirán a números persas al mostrar los montos.';
$string['cost'] = 'Costo';
$string['cost_help'] = 'El precio del curso puede comenzar desde 0. Un valor de 0 significa que el curso es gratuito.';
$string['coupon_class'] = 'Clase del cupón de descuento';
$string['coupon_class_desc'] =
    'Especifica la ruta de la clase del cupón de descuento. Ejemplo: <code dir="ltr">local_coupon\object\coupon</code>. La clase del cupón debe implementar <code dir="ltr">enrol_cart\local\object\coupon_interface</code>.';
$string['coupon_code'] = 'Código de cupón';
$string['coupon_discount'] = 'Descuento del cupón';
$string['coupon_enable'] = 'Habilitar cupones de descuento';
$string['coupon_enable_desc'] =
    'El carrito de compras admite el uso de cupones de descuento si hay un complemento de cupón compatible instalado en el sistema.';
$string['currency'] = 'Moneda';
$string['date'] = 'Fecha';
$string['delete_expired_carts'] = 'Eliminar carritos vencidos';
$string['discount'] = 'Descuento';
$string['discount_amount'] = 'Monto del descuento';
$string['discount_type'] = 'Tipo de descuento';
$string['enable_guest_cart'] = 'Permitir que los invitados agreguen/eliminan cursos del carrito';
$string['enable_guest_cart_desc'] =
    'Si está habilitado, los usuarios invitados pueden agregar cursos al carrito de compras y eliminarlos si lo desean.';

$string['enrol_end_date'] = 'Fecha de finalización de la inscripción';
$string['enrol_end_date_help'] = 'Si está habilitado, los usuarios pueden inscribirse hasta esta fecha.';
$string['enrol_instance_defaults'] = 'Valores predeterminados de inscripción';
$string['enrol_instance_defaults_desc'] = 'Configuración predeterminada para inscribir en nuevos cursos';
$string['enrol_period'] = 'Duración de la inscripción';
$string['enrol_period_desc'] = 'El período durante el cual los usuarios permanecen inscritos en el curso. Un valor de 0 significa ilimitado.';
$string['enrol_period_help'] = 'La duración de la inscripción después de que el usuario se inscriba. Un valor de 0 significa ilimitado.';
$string['enrol_start_date'] = 'Fecha de inicio de la inscripción';
$string['enrol_start_date_help'] = 'Si está habilitado, los usuarios pueden inscribirse a partir de esta fecha.';
$string['error_cost'] = 'El monto debe ser un número.';
$string['error_coupon_apply_failed'] = 'Error al aplicar el código de descuento.';
$string['error_coupon_class_not_found'] = 'No se encontró la clase del cupón de descuento.';
$string['error_coupon_class_not_implemented'] = 'La clase del cupón de descuento no está implementada correctamente.';
$string['error_coupon_disabled'] = 'El código de descuento está deshabilitado.';
$string['error_coupon_is_invalid'] = 'El código de descuento no es válido.';
$string['error_disabled'] = 'El carrito está deshabilitado.';
$string['error_discount_amount_is_higher'] = 'El monto del descuento no puede exceder el precio original.';
$string['error_discount_amount_is_invalid'] = 'El monto del descuento no es válido.';
$string['error_discount_amount_must_be_a_number'] = 'El monto del descuento debe ser un número.';
$string['error_discount_amount_percentage_is_invalid'] = 'El porcentaje de descuento debe ser un número entero entre 0 y 100.';
$string['error_discount_type_is_invalid'] = 'El tipo de descuento no es válido.';
$string['error_enrol_end_date'] = 'La fecha de finalización no puede ser anterior a la fecha de inicio.';
$string['error_gateway_is_invalid'] = 'La pasarela de pago seleccionada no es válida.';
$string['error_group_is_invalid'] = 'El grupo no es válido.';
$string['error_invalid_cart'] = 'El carrito no es válido.';
$string['error_no_payment_accounts_available'] = 'No hay cuentas de pago disponibles.';
$string['error_no_payment_currency_available'] = 'No se pueden realizar pagos en ninguna moneda. Asegúrese de que al menos una pasarela de pago esté activa.';
$string['error_no_payment_gateway_available'] = 'No hay una pasarela de pago disponible. Especifique la cuenta y moneda antes de seleccionar una pasarela.';
$string['error_status_no_payment_account'] = 'No se puede habilitar la inscripción mediante carrito sin especificar una cuenta de pago.';
$string['error_status_no_payment_currency'] = 'No se puede habilitar la inscripción mediante carrito sin especificar una moneda de pago.';

$string['event_cart_deleted'] = 'Carrito vaciado';
$string['fixed'] = 'Monto fijo';
$string['free'] = 'Gratis';
$string['gateway_wait'] = 'Por favor espera...';
$string['instructions'] = 'Instrucciones de la página de inscripción';

$string['msg_cart_cancel_failed'] = 'Hubo un problema con el proceso de tu carrito.';
$string['msg_cart_cancel_success'] = 'Tu carrito ha sido cancelado.';
$string['msg_cart_changed'] = 'Los artículos o el monto a pagar en el carrito han cambiado.';
$string['msg_cart_edit_blocked'] = 'Actualmente no es posible editar o cambiar el carrito de compras.';
$string['msg_enrolment_already'] = 'Ya estás inscrito en el curso "{$a->title}".';
$string['msg_enrolment_deleted'] = 'Se ha eliminado una de las inscripciones del curso.';
$string['msg_enrolment_failed'] = 'Hubo un problema con tu proceso de inscripción.';
$string['msg_enrolment_success'] = 'Tu inscripción en los siguientes cursos se ha completado correctamente.';

$string['my_purchases'] = 'Mis compras';
$string['never'] = 'Nunca';
$string['no_discount'] = 'Sin descuento';
$string['no_items'] = 'No se encontraron artículos.';
$string['not_delete_cart_with_payment_record'] = 'No eliminar carritos con registros de pago';
$string['not_delete_cart_with_payment_record_desc'] = 'Si está habilitado, los carritos con registros en la tabla de pagos no se eliminarán.';
$string['one_day'] = 'Un día';
$string['one_month'] = 'Un mes';
$string['order'] = 'Pedido';
$string['order_id'] = 'ID del pedido';
$string['pay'] = 'Pagar';
$string['payable'] = 'A pagar';
$string['payment'] = 'Pago';
$string['payment_account'] = 'Cuenta de pago';
$string['payment_account_help'] = 'Los pagos se depositarán en esta cuenta.';
$string['payment_completion_time'] = 'Tiempo máximo para completar el pago';
$string['payment_completion_time_desc'] =
    'Esta configuración define el tiempo máximo permitido después de iniciar un pago para que el usuario lo complete. Durante este tiempo, los artículos del carrito, el monto y cualquier cupón estarán bloqueados.';
$string['payment_currency'] = 'Unidad monetaria';
$string['pending_payment_cart_lifetime'] = 'Periodo de retención de carritos con pago pendiente';
$string['pending_payment_cart_lifetime_desc'] =
    'Los carritos con pagos pendientes se eliminarán permanentemente después del período especificado. Un valor de cero significa ilimitado.';
$string['percentage'] = 'Porcentaje';
$string['pluginname'] = 'Carrito de compras';
$string['pluginname_desc'] =
    'El método de inscripción mediante carrito crea un carrito de compras a nivel del sitio que permite a los usuarios agregar cursos al carrito y comprarlos.';
$string['price'] = 'Precio';

$string['privacy:metadata:enrol_cart'] = 'Detalles de los carritos de compra utilizados para la inscripción.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'La marca de tiempo cuando se procesó el carrito.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'El código del cupón aplicado al carrito, si existe.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'El ID del cupón aplicado al carrito, si existe.';
$string['privacy:metadata:enrol_cart:created_at'] = 'La marca de tiempo cuando se creó el carrito.';
$string['privacy:metadata:enrol_cart:currency'] = 'La moneda utilizada en el carrito.';
$string['privacy:metadata:enrol_cart:payable'] = 'El monto total a pagar en el carrito.';
$string['privacy:metadata:enrol_cart:price'] = 'El precio total del carrito.';
$string['privacy:metadata:enrol_cart:status'] = 'El estado del carrito (por ejemplo, pendiente, completado).';
$string['privacy:metadata:enrol_cart:user_id'] = 'El ID del usuario asociado con el carrito.';
$string['privacy:metadata:enrol_cart_items'] = 'Detalles de los artículos en un carrito de compras.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'El ID del carrito que contiene el artículo.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'El ID de la instancia de inscripción asociada con el artículo.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'El monto a pagar por el artículo.';
$string['privacy:metadata:enrol_cart_items:price'] = 'El precio del artículo.';
$string['privacy:metadata:reason'] = 'El complemento enrol_cart no almacena directamente ningún dato del usuario.';

$string['proceed_to_checkout'] = 'Proceder al pago';
$string['select_payment_method'] = 'Seleccionar método de pago';
$string['six_months'] = 'Seis meses';
$string['status'] = 'Habilitar inscripción mediante carrito de compras';
$string['status_canceled'] = 'Cancelado';
$string['status_checkout'] = 'Pago';
$string['status_current'] = 'Activo';
$string['status_delivered'] = 'Entregado';
$string['status_desc'] = 'Permite a los usuarios agregar cursos al carrito de compras por defecto.';
$string['three_months'] = 'Tres meses';
$string['total'] = 'Total';
$string['total_order_amount'] = 'Monto total';
$string['unknown'] = 'Desconocido';
$string['unlimited'] = 'Ilimitado';
$string['user'] = 'Usuario';
$string['verify_payment_on_delivery'] = 'Verificar el monto final con el pago al entregar';
$string['verify_payment_on_delivery_desc'] =
    'Si está habilitado, el monto final del carrito se comparará con el monto pagado al momento de la entrega. El carrito solo se entregará si los montos coinciden.';
$string['view'] = 'Ver';
