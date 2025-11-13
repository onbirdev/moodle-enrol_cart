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
$string['a_week'] = 'Uma semana';
$string['add_to_cart'] = 'Adicionar ao carrinho';
$string['add_to_group'] = 'Adicionar ao grupo';
$string['apply'] = 'Aplicar';
$string['assign_role'] = 'Função do usuário';
$string['assign_role_desc'] = 'A função atribuída aos usuários após o pagamento e matrícula.';
$string['availability'] = 'Condições de disponibilidade';
$string['availability_help'] = 'Restringe quais usuários podem se inscrever via carrinho com base nas condições de disponibilidade.';
$string['cancel'] = 'Cancelar';
$string['cancel_cart'] = 'Cancelar';
$string['canceled_cart_lifetime'] = 'Período de retenção do carrinho cancelado';
$string['canceled_cart_lifetime_desc'] =
    'Carrinhos cancelados serão excluídos permanentemente após o período especificado. Um valor zero significa ilimitado.';

$string['cart:config'] = 'Configurar instâncias de inscrição via carrinho';
$string['cart:manage'] = 'Gerenciar usuários inscritos';
$string['cart:unenrol'] = 'Cancelar inscrição de usuários do curso';
$string['cart:unenrolself'] = 'Cancelar a própria inscrição do curso';
$string['cart:view'] = 'Ver carrinho de compras';

$string['cart_is_empty'] = 'Seu carrinho está vazio';
$string['cart_status'] = 'Status';
$string['checkout'] = 'Finalizar compra';
$string['choose_gateway'] = 'Escolha o gateway de pagamento:';
$string['complete_purchase'] = 'Concluir compra';
$string['convert_irr_to_irt'] = 'Converter IRR para Toman';
$string['convert_irr_to_irt_desc'] =
    'Se ativado, valores em Rial iraniano serão convertidos para Toman apenas para exibição. <b>(Essa configuração afeta apenas a forma como o valor é mostrado; ao criar ou editar métodos de inscrição, os valores devem ser informados em Rial.)</b>';
$string['convert_numbers_to_persian'] = 'Converter números em inglês para persa';
$string['convert_numbers_to_persian_desc'] =
    'Se ativado, os números em inglês serão convertidos para persa ao exibir valores.';
$string['cost'] = 'Custo';
$string['cost_help'] = 'O preço do curso pode começar em 0. Um valor de 0 significa que o curso é gratuito.';
$string['coupon_class'] = 'Classe do cupom de desconto';
$string['coupon_class_desc'] =
    'Especifique o caminho da classe do cupom de desconto. Exemplo: <code dir="ltr">local_coupon\object\coupon</code>. A classe do cupom deve implementar <code dir="ltr">enrol_cart\local\object\coupon_interface</code>.';
$string['coupon_code'] = 'Código do cupom';
$string['coupon_discount'] = 'Desconto do cupom';
$string['coupon_enable'] = 'Ativar cupons de desconto';
$string['coupon_enable_desc'] =
    'O carrinho de compras suporta o uso de cupons de desconto se um plugin de cupom compatível estiver instalado no sistema.';
$string['currency'] = 'Moeda';
$string['date'] = 'Data';
$string['delete_expired_carts'] = 'Excluir carrinhos expirados';
$string['discount'] = 'Desconto';
$string['discount_amount'] = 'Valor do desconto';
$string['discount_type'] = 'Tipo de desconto';
$string['enable_guest_cart'] = 'Permitir que convidados adicionem/removam cursos do carrinho';
$string['enable_guest_cart_desc'] =
    'Se ativado, usuários convidados poderão adicionar cursos ao carrinho e removê-los quando necessário.';

$string['enrol_end_date'] = 'Data final da inscrição';
$string['enrol_end_date_help'] = 'Se ativado, os usuários poderão se inscrever até esta data.';
$string['enrol_instance_defaults'] = 'Padrões de inscrição';
$string['enrol_instance_defaults_desc'] = 'Configurações padrão para novas inscrições em cursos';
$string['enrol_period'] = 'Duração da inscrição';
$string['enrol_period_desc'] = 'O período em que os usuários permanecem inscritos no curso. Um valor de 0 significa ilimitado.';
$string['enrol_period_help'] = 'A duração da inscrição após a matrícula. Um valor de 0 significa ilimitado.';
$string['enrol_start_date'] = 'Data inicial da inscrição';
$string['enrol_start_date_help'] = 'Se ativado, os usuários poderão se inscrever a partir desta data.';
$string['error_cost'] = 'O valor deve ser um número.';
$string['error_coupon_apply_failed'] = 'Falha ao aplicar o código de desconto.';
$string['error_coupon_class_not_found'] = 'A classe do cupom de desconto não foi encontrada.';
$string['error_coupon_class_not_implemented'] = 'A classe do cupom de desconto não foi implementada corretamente.';
$string['error_coupon_disabled'] = 'O código de desconto está desativado.';
$string['error_coupon_is_invalid'] = 'O código de desconto é inválido.';
$string['error_disabled'] = 'O carrinho está desativado.';
$string['error_discount_amount_is_higher'] = 'O valor do desconto não pode exceder o preço original.';
$string['error_discount_amount_is_invalid'] = 'O valor do desconto é inválido.';
$string['error_discount_amount_must_be_a_number'] = 'O valor do desconto deve ser um número.';
$string['error_discount_amount_percentage_is_invalid'] = 'A porcentagem de desconto deve ser um número inteiro entre 0 e 100.';
$string['error_discount_type_is_invalid'] = 'O tipo de desconto é inválido.';
$string['error_enrol_end_date'] = 'A data final da inscrição não pode ser anterior à data inicial.';
$string['error_gateway_is_invalid'] = 'O gateway de pagamento selecionado é inválido.';
$string['error_group_is_invalid'] = 'O grupo é inválido.';
$string['error_invalid_cart'] = 'O carrinho é inválido.';
$string['error_no_payment_accounts_available'] = 'Nenhuma conta de pagamento disponível.';
$string['error_no_payment_currency_available'] = 'Não é possível realizar pagamentos em nenhuma moeda. Certifique-se de que pelo menos um gateway de pagamento esteja ativo.';
$string['error_no_payment_gateway_available'] = 'Nenhum gateway de pagamento disponível. Especifique a conta e a moeda antes de selecionar um gateway.';
$string['error_status_no_payment_account'] = 'A inscrição via carrinho não pode ser ativada sem especificar uma conta de pagamento.';
$string['error_status_no_payment_currency'] = 'A inscrição via carrinho não pode ser ativada sem especificar uma moeda.';

$string['event_cart_deleted'] = 'Carrinho limpo';
$string['fixed'] = 'Valor fixo';
$string['free'] = 'Gratuito';
$string['gateway_wait'] = 'Por favor, aguarde...';
$string['instructions'] = 'Instruções da página de inscrição';

$string['msg_cart_cancel_failed'] = 'Houve um problema com o processo do carrinho.';
$string['msg_cart_cancel_success'] = 'Seu carrinho foi cancelado.';
$string['msg_cart_changed'] = 'Os itens ou o valor a pagar no carrinho foram alterados.';
$string['msg_cart_edit_blocked'] = 'Não é possível editar ou alterar o carrinho neste momento.';
$string['msg_enrolment_already'] = 'Você já está inscrito no curso "{$a->title}".';
$string['msg_enrolment_deleted'] = 'Uma das inscrições no curso foi excluída.';
$string['msg_enrolment_failed'] = 'Ocorreu um problema no processo de inscrição.';
$string['msg_enrolment_success'] = 'Sua inscrição no(s) curso(s) abaixo foi concluída com sucesso.';

$string['my_purchases'] = 'Minhas compras';
$string['never'] = 'Nunca';
$string['no_discount'] = 'Sem desconto';
$string['no_items'] = 'Nenhum item encontrado.';
$string['not_delete_cart_with_payment_record'] = 'Não excluir carrinhos com registros de pagamento';
$string['not_delete_cart_with_payment_record_desc'] = 'Se ativado, carrinhos com registros na tabela de pagamentos não serão excluídos.';
$string['one_day'] = 'Um dia';
$string['one_month'] = 'Um mês';
$string['order'] = 'Pedido';
$string['order_id'] = 'ID do pedido';
$string['pay'] = 'Pagar';
$string['payable'] = 'A pagar';
$string['payment'] = 'Pagamento';
$string['payment_account'] = 'Conta de pagamento';
$string['payment_account_help'] = 'Os pagamentos serão depositados nesta conta.';
$string['payment_completion_time'] = 'Tempo máximo para conclusão do pagamento';
$string['payment_completion_time_desc'] =
    'Define o tempo máximo permitido após o início de um pagamento para o usuário concluí-lo. Durante esse período, os itens, valores e cupons do carrinho serão bloqueados.';
$string['payment_currency'] = 'Unidade monetária';
$string['pending_payment_cart_lifetime'] = 'Período de retenção de carrinhos com pagamento pendente';
$string['pending_payment_cart_lifetime_desc'] =
    'Carrinhos com pagamento pendente serão excluídos permanentemente após o período especificado. Um valor zero significa ilimitado.';
$string['percentage'] = 'Porcentagem';
$string['pluginname'] = 'Carrinho de Compras';
$string['pluginname_desc'] =
    'O método de inscrição via carrinho cria um carrinho de compras em todo o site, permitindo que os usuários adicionem cursos ao carrinho e os comprem.';
$string['price'] = 'Preço';

$string['privacy:metadata:enrol_cart'] = 'Detalhes dos carrinhos de compras usados para inscrição.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'O momento em que o carrinho foi finalizado.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'O código do cupom aplicado ao carrinho, se houver.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'O ID do cupom aplicado ao carrinho, se houver.';
$string['privacy:metadata:enrol_cart:created_at'] = 'O momento em que o carrinho foi criado.';
$string['privacy:metadata:enrol_cart:currency'] = 'A moeda usada no carrinho.';
$string['privacy:metadata:enrol_cart:payable'] = 'O valor total a pagar no carrinho.';
$string['privacy:metadata:enrol_cart:price'] = 'O preço total do carrinho.';
$string['privacy:metadata:enrol_cart:status'] = 'O status do carrinho (ex.: pendente, concluído).';
$string['privacy:metadata:enrol_cart:user_id'] = 'O ID do usuário associado ao carrinho.';
$string['privacy:metadata:enrol_cart_items'] = 'Detalhes dos itens em um carrinho de compras.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'O ID do carrinho contendo o item.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'O ID da instância de inscrição associada ao item.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'O valor a pagar pelo item.';
$string['privacy:metadata:enrol_cart_items:price'] = 'O preço do item.';
$string['privacy:metadata:reason'] = 'O plugin enrol_cart não armazena diretamente dados de usuários.';

$string['proceed_to_checkout'] = 'Ir para o checkout';
$string['select_payment_method'] = 'Selecione o método de pagamento';
$string['six_months'] = 'Seis meses';
$string['status'] = 'Ativar inscrição via carrinho de compras';
$string['status_canceled'] = 'Cancelado';
$string['status_checkout'] = 'Checkout';
$string['status_current'] = 'Ativo';
$string['status_delivered'] = 'Entregue';
$string['status_desc'] = 'Permite que os usuários adicionem cursos ao carrinho por padrão.';
$string['three_months'] = 'Três meses';
$string['total'] = 'Total';
$string['total_order_amount'] = 'Valor total do pedido';
$string['unknown'] = 'Desconhecido';
$string['unlimited'] = 'Ilimitado';
$string['user'] = 'Usuário';
$string['verify_payment_on_delivery'] = 'Verificar valor final com pagamento na entrega';
$string['verify_payment_on_delivery_desc'] =
    'Se ativado, o valor final do carrinho será comparado com o valor pago no momento da entrega. O carrinho só será entregue se os valores coincidirem.';
$string['view'] = 'Ver';
