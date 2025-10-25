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
$string['a_week'] = 'Une semaine';
$string['add_to_cart'] = 'Ajouter au panier';
$string['add_to_group'] = 'Ajouter au groupe';
$string['apply'] = 'Appliquer';
$string['assign_role'] = 'Attribuer un rôle';
$string['assign_role_desc'] = 'Sélectionnez le rôle à attribuer aux utilisateurs après avoir effectué un paiement.';
$string['availability'] = 'Conditions d’accès';
$string['availability_help'] = 'Définissez quels utilisateurs peuvent s’inscrire via le panier en fonction des conditions d’accès.';
$string['cancel'] = 'Annuler';
$string['cancel_cart'] = 'Annuler';
$string['canceled_cart_lifetime'] = 'Durée de vie des paniers annulés';
$string['canceled_cart_lifetime_desc'] =
    'Les paniers annulés seront complètement supprimés après le temps spécifié. Une valeur de zéro signifie illimité.';

$string['cart:config'] = 'Configurer les instances du plugin';
$string['cart:manage'] = 'Gérer les utilisateurs inscrits';
$string['cart:unenrol'] = 'Désinscrire les utilisateurs du cours';
$string['cart:unenrolself'] = 'Se désinscrire soi-même du cours';
$string['cart:view'] = 'Voir le panier';

$string['cart_is_empty'] = 'Votre panier est vide';
$string['cart_status'] = 'Statut';
$string['checkout'] = 'Paiement';
$string['choose_gateway'] = 'Choisir un moyen de paiement :';
$string['complete_purchase'] = 'Finaliser l’achat';
$string['convert_irr_to_irt'] = 'Convertir IRR en IRT';
$string['convert_irr_to_irt_desc'] =
    'Lorsque cette option est sélectionnée, les montants en rial iranien seront convertis en toman et affichés. <b>(Ce paramètre n’est applicable que pour l’affichage des montants à l’utilisateur. Lors de la création ou de la modification des méthodes d’inscription, les montants doivent toujours être saisis en Rial.)</b>';
$string['convert_numbers_to_persian'] = 'Convertir des nombres anglais en persan';
$string['convert_numbers_to_persian_desc'] =
    'Lorsque cette option est sélectionnée, les nombres anglais seront convertis en nombres persans lors de l’affichage des montants.';
$string['cost'] = 'Coût';
$string['cost_help'] = 'Le coût du cours peut commencer à 0. La valeur 0 signifie que le cours est gratuit.';
$string['coupon_class'] = 'Classe de coupon de réduction';
$string['coupon_class_desc'] =
    'Spécifiez le chemin d’accès à la classe de coupon de réduction. Par exemple : <code>local_coupon\object\coupon</code>. The discount coupon class must implement <code>enrol_cart\local\object\coupon_interface</code>.';
$string['coupon_code'] = 'Code promo';
$string['coupon_discount'] = 'Coupon de réduction';
$string['coupon_enable'] = 'Activer le coupon de réduction';
$string['coupon_enable_desc'] =
    'Le panier d’achat prend en charge l’utilisation de coupons de réduction si le plugin coupon de réduction est disponible dans le système. Si oui, il peut être utilisé dans le panier.';
$string['currency'] = 'Devise';
$string['date'] = 'Date';
$string['delete_expired_carts'] = 'Supprimer les paniers expirés';
$string['discount'] = 'Réduction';
$string['discount_amount'] = 'Montant du rabais';
$string['discount_type'] = 'Type de rabais';
$string['enable_guest_cart'] = 'Permettre aux invités d’ajouter et de supprimer des cours du panier';
$string['enable_guest_cart_desc'] = 'Si cette option est activée, les utilisateurs invités pourront ajouter des cours à leur panier et les supprimer.';

$string['enrol_end_date'] = 'Date de fin';
$string['enrol_end_date_help'] = 'Si activé, les utilisateurs peuvent être inscrits jusqu’à cette date seulement.';
$string['enrol_instance_defaults'] = 'Inscription par défaut';
$string['enrol_instance_defaults_desc'] = 'Paramètres par défaut pour l’inscription à de nouveaux cours';
$string['enrol_period'] = 'Durée de l’inscription';
$string['enrol_period_desc'] =
    'Durée par défaut de la validité de l’inscription. S’il est réglé à zéro, la durée d’inscription sera illimitée par défaut.';
$string['enrol_period_help'] =
    'Durée de validité de l’inscription, à compter du moment où l’utilisateur est inscrit. Si désactivé, la durée de l’inscription sera illimitée.';
$string['enrol_start_date'] = 'Date de début';
$string['enrol_start_date_help'] = 'Si activé, les utilisateurs ne peuvent être inscrits qu’à partir de cette date.';

$string['error_cost'] = 'Le coût doit être un nombre.';
$string['error_coupon_apply_failed'] = 'Échec de l’application du coupon';
$string['error_coupon_class_not_found'] = 'Class de coupon de réduction introuvable.';
$string['error_coupon_class_not_implemented'] = 'Class de coupon de réduction pas implémenté correctement.';
$string['error_coupon_disabled'] = 'Coupon désactivé.';
$string['error_coupon_is_invalid'] = 'Le coupon n’est pas valable.';
$string['error_disabled'] = 'Le panier est désactivé.';
$string['error_discount_amount_is_higher'] = 'Le montant du rabais ne peut être supérieur au montant initial';
$string['error_discount_amount_is_invalid'] = 'Le montant du rabais n’est pas valable.';
$string['error_discount_amount_must_be_a_number'] = 'Le montant du rabais doit être un nombre.';
$string['error_discount_amount_percentage_is_invalid'] =
    'Le pourcentage de réduction doit être un entier compris entre 0 et 100.';
$string['error_discount_type_is_invalid'] = 'Le type de rabais n’est pas valable.';
$string['error_enrol_end_date'] = 'La date de fin d’inscription ne peut être antérieure à la date de début.';
$string['error_gateway_is_invalid'] = 'Le moyen de paiement sélectionné n’est pas correct.';
$string['error_group_is_invalid'] = 'Le groupe est invalide.';
$string['error_invalid_cart'] = 'Panier non valide';
$string['error_no_payment_accounts_available'] = 'Aucun compte de paiement disponible.';
$string['error_no_payment_currency_available'] =
    'Les paiements ne peuvent être effectués, pour aucune devise. Assurez-vous qu’au moins une passerelle de paiement est active.';
$string['error_no_payment_gateway_available'] =
    'Aucune passerelle de paiement n’est disponible. Veuillez spécifier le compte de paiement et la passerelle de paiement pour sélectionner une passerelle de paiement.';
$string['error_status_no_payment_account'] = 'Les inscriptions ne peuvent pas être activées sans spécifier le compte de paiement.';
$string['error_status_no_payment_currency'] = 'Les inscriptions ne peuvent pas être activées sans spécifier la devise de paiement';

$string['event_cart_deleted'] = 'Le panier a été effacé';
$string['fixed'] = 'Montant fixe';
$string['free'] = 'Gratuit';
$string['gateway_wait'] = 'Veuillez patienter...';
$string['instructions'] = 'Instructions sur la page d’inscription';

$string['msg_cart_cancel_failed'] = 'Il y a eu un problème avec le processus de votre panier.';
$string['msg_cart_cancel_success'] = 'Votre panier a été annulé.';
$string['msg_cart_changed'] = 'Le ou les articles ou le montant payable dans le panier a/ont changé.';
$string['msg_cart_edit_blocked'] = 'Il n’est actuellement pas possible d’éditer ou de modifier le panier.';
$string['msg_enrolment_already'] = 'Vous vous êtes déjà inscrit au cours "{$a->title}".';
$string['msg_enrolment_deleted'] = 'Une des inscriptions a été supprimée.';
$string['msg_enrolment_failed'] = 'Votre processus d’inscription a rencontré un problème.';
$string['msg_enrolment_success'] = 'Votre inscription au(x) cours ci-dessous a bien été enregistrée.';

$string['my_purchases'] = 'Mes achats';
$string['never'] = 'Jamais';
$string['no_discount'] = 'Pas de réduction';
$string['no_items'] = 'Aucun article trouvé.';
$string['not_delete_cart_with_payment_record'] = 'Ne pas supprimer les paniers avec des enregistrements de paiement';
$string['not_delete_cart_with_payment_record_desc'] =
    'Si cette option est sélectionnée, les paniers avec des enregistrements dans la table de paiement ne seront pas supprimés.';
$string['one_day'] = 'Un jour';
$string['one_month'] = 'Un mois';
$string['order'] = 'Commande';
$string['order_id'] = 'identifiant de commande';
$string['pay'] = 'Payer';
$string['payable'] = 'À payer';
$string['payment'] = 'Paiement';
$string['payment_account'] = 'Compte de paiement';
$string['payment_account_help'] = 'Les frais d’inscription seront versés sur ce compte.';
$string['payment_completion_time'] = 'Délai de paiement';
$string['payment_completion_time_desc'] =
    'Cette variable spécifie le temps maximum octroyé à l’un utilisateur pour compléter son paiement après l’avoir initié. Pendant cette période, les articles, le montant du panier et le code de réduction seront verrouillés pour l’utilisateur.';
$string['payment_currency'] = 'Devise';
$string['pending_payment_cart_lifetime'] = 'Durée de vie des paniers de paiement en attente';
$string['pending_payment_cart_lifetime_desc'] =
    'Les paniers de paiement en attente seront complètement retirés après le temps spécifié. Une valeur de zéro signifie illimité.';
$string['percentage'] = 'Pourcentage';
$string['pluginname'] = 'Panier';
$string['pluginname_desc'] =
    'La méthode d’inscription au panier crée un panier sur l’ensemble du site et offre la possibilité d’ajouter le cours au panier.';
$string['price'] = 'Prix';

$string['privacy:metadata:enrol_cart'] = 'Détails des paniers utilisés pour l’inscription.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'L’horodatage du moment où le panier a été consulté.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'Le code du coupon appliqué au panier, le cas échéant.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'L’identifiant du coupon appliqué au panier, le cas échéant.';
$string['privacy:metadata:enrol_cart:created_at'] = 'L’horodatage de la création du panier.';
$string['privacy:metadata:enrol_cart:currency'] = 'La devise utilisée pour le panier.';
$string['privacy:metadata:enrol_cart:payable'] = 'Le montant total à payer dans le panier.';
$string['privacy:metadata:enrol_cart:price'] = 'Le prix total du panier.';
$string['privacy:metadata:enrol_cart:status'] = 'Le statut du panier (p. ex., en attente, terminé).';
$string['privacy:metadata:enrol_cart:user_id'] = 'L’identifiant de l’utilisateur associé au panier.';
$string['privacy:metadata:enrol_cart_items'] = 'Détails des articles dans un panier.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'L’identifiant du panier contenant l’article.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'L’identifiant de l’instance d’inscription associée à l’article.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'Le montant à payer pour l’article.';
$string['privacy:metadata:enrol_cart_items:price'] = 'Le prix de l’article.';
$string['privacy:metadata:reason'] = 'Le plugin enrol_cart ne stocke pas de données utilisateur directement.';

$string['proceed_to_checkout'] = 'Procéder au paiement';
$string['select_payment_method'] = 'Sélectionner la méthode de paiement';
$string['six_months'] = 'Six mois';
$string['status'] = 'Activer les inscriptions manuelles';
$string['status_canceled'] = 'Annulé';
$string['status_checkout'] = 'Paiement';
$string['status_current'] = 'Actuellement actif';
$string['status_delivered'] = 'Livré';
$string['status_desc'] = 'Permettre aux utilisateurs d’ajouter un cours au panier par défaut.';
$string['three_months'] = 'Trois mois';
$string['total'] = 'Total';
$string['total_order_amount'] = 'Montant total';
$string['unknown'] = 'Inconnu';
$string['unlimited'] = 'Illimité';
$string['user'] = 'Utilisateur';
$string['verify_payment_on_delivery'] = 'Vérifier le montant final avec paiement à la livraison';
$string['verify_payment_on_delivery_desc'] =
    'Lorsque cette option est sélectionnée, le montant final du panier sera comparé au montant du paiement lors de la livraison et le panier sera livré s’ils correspondent.';
$string['view'] = 'Voir';
