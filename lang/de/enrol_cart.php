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
$string['a_week'] = 'Eine Woche';
$string['add_to_cart'] = 'In den Warenkorb legen';
$string['add_to_group'] = 'Zur Gruppe hinzufügen';
$string['apply'] = 'Anwenden';
$string['assign_role'] = 'Benutzerrolle';
$string['assign_role_desc'] = 'Die Rolle, die Benutzern nach der Zahlung und Einschreibung zugewiesen wird.';
$string['availability'] = 'Verfügbarkeitsbedingungen';
$string['availability_help'] = 'Beschränken Sie, welche Benutzer sich über den Warenkorb einschreiben können, basierend auf den Verfügbarkeitsbedingungen.';
$string['cancel'] = 'Abbrechen';
$string['cancel_cart'] = 'Abbrechen';
$string['canceled_cart_lifetime'] = 'Aufbewahrungszeit abgebrochener Warenkörbe';
$string['canceled_cart_lifetime_desc'] =
    'Abgebrochene Warenkörbe werden nach dem angegebenen Zeitraum dauerhaft gelöscht. Ein Wert von null bedeutet unbegrenzt.';

$string['cart:config'] = 'Warenkorb-Einschreibinstanzen konfigurieren';
$string['cart:manage'] = 'Eingeschriebene Benutzer verwalten';
$string['cart:unenrol'] = 'Benutzer aus dem Kurs austragen';
$string['cart:unenrolself'] = 'Selbst aus dem Kurs austragen';
$string['cart:view'] = 'Warenkorb anzeigen';

$string['cart_is_empty'] = 'Ihr Warenkorb ist leer';
$string['cart_status'] = 'Status';
$string['checkout'] = 'Zur Kasse';
$string['choose_gateway'] = 'Zahlungsgateway auswählen:';
$string['complete_purchase'] = 'Kauf abschließen';
$string['convert_irr_to_irt'] = 'IRR in Toman umrechnen';
$string['convert_irr_to_irt_desc'] =
    'Wenn aktiviert, werden Beträge in Iranischen Rial zur Anzeige in Toman umgerechnet. <b>(Diese Einstellung beeinflusst nur die Anzeige; beim Erstellen oder Bearbeiten von Einschreibmethoden müssen Beträge weiterhin in Rial eingegeben werden.)</b>';
$string['convert_numbers_to_persian'] = 'Englische Zahlen in Persisch umwandeln';
$string['convert_numbers_to_persian_desc'] =
    'Wenn aktiviert, werden englische Ziffern bei der Betragsanzeige in persische Ziffern umgewandelt.';
$string['cost'] = 'Kosten';
$string['cost_help'] = 'Der Kurspreis kann bei 0 beginnen. Ein Wert von 0 bedeutet, dass der Kurs kostenlos ist.';
$string['coupon_class'] = 'Rabattcoupon-Klasse';
$string['coupon_class_desc'] =
    'Geben Sie den Klassenpfad des Rabattcoupons an. Beispiel: <code dir="ltr">local_coupon\object\coupon</code>. Die Klasse muss <code dir="ltr">enrol_cart\local\object\coupon_interface</code> implementieren.';
$string['coupon_code'] = 'Gutscheincode';
$string['coupon_discount'] = 'Gutscheinrabatt';
$string['coupon_enable'] = 'Rabattcoupons aktivieren';
$string['coupon_enable_desc'] =
    'Der Warenkorb unterstützt die Verwendung von Rabattcoupons, wenn ein kompatibles Gutschein-Plugin installiert ist.';
$string['currency'] = 'Währung';
$string['date'] = 'Datum';
$string['delete_expired_carts'] = 'Abgelaufene Warenkörbe löschen';
$string['discount'] = 'Rabatt';
$string['discount_amount'] = 'Rabattbetrag';
$string['discount_type'] = 'Rabattart';
$string['enable_guest_cart'] = 'Gästen erlauben, Kurse in den Warenkorb zu legen oder zu entfernen';
$string['enable_guest_cart_desc'] =
    'Wenn aktiviert, können Gastbenutzer Kurse zum Warenkorb hinzufügen und bei Bedarf entfernen.';

$string['enrol_end_date'] = 'Einschreibungsenddatum';
$string['enrol_end_date_help'] = 'Wenn aktiviert, können sich Benutzer bis zu diesem Datum einschreiben.';
$string['enrol_instance_defaults'] = 'Standardwerte für Einschreibung';
$string['enrol_instance_defaults_desc'] = 'Standardeinstellungen für neue Kurseinschreibungen';
$string['enrol_period'] = 'Einschreibungsdauer';
$string['enrol_period_desc'] = 'Der Zeitraum, in dem Benutzer im Kurs eingeschrieben bleiben. Ein Wert von 0 bedeutet unbegrenzt.';
$string['enrol_period_help'] = 'Die Dauer der Einschreibung nach der Anmeldung. Ein Wert von 0 bedeutet unbegrenzt.';
$string['enrol_start_date'] = 'Einschreibungsstartdatum';
$string['enrol_start_date_help'] = 'Wenn aktiviert, können sich Benutzer ab diesem Datum einschreiben.';
$string['error_cost'] = 'Der Betrag muss eine Zahl sein.';
$string['error_coupon_apply_failed'] = 'Der Gutscheincode konnte nicht angewendet werden.';
$string['error_coupon_class_not_found'] = 'Die Gutschein-Klasse wurde nicht gefunden.';
$string['error_coupon_class_not_implemented'] = 'Die Gutschein-Klasse ist nicht korrekt implementiert.';
$string['error_coupon_disabled'] = 'Der Gutscheincode ist deaktiviert.';
$string['error_coupon_is_invalid'] = 'Der Gutscheincode ist ungültig.';
$string['error_disabled'] = 'Der Warenkorb ist deaktiviert.';
$string['error_discount_amount_is_higher'] = 'Der Rabattbetrag darf den Originalpreis nicht überschreiten.';
$string['error_discount_amount_is_invalid'] = 'Der Rabattbetrag ist ungültig.';
$string['error_discount_amount_must_be_a_number'] = 'Der Rabattbetrag muss eine Zahl sein.';
$string['error_discount_amount_percentage_is_invalid'] = 'Der Rabattprozentsatz muss eine Ganzzahl zwischen 0 und 100 sein.';
$string['error_discount_type_is_invalid'] = 'Der Rabatttyp ist ungültig.';
$string['error_enrol_end_date'] = 'Das Enddatum darf nicht vor dem Startdatum liegen.';
$string['error_gateway_is_invalid'] = 'Das ausgewählte Zahlungsgateway ist ungültig.';
$string['error_group_is_invalid'] = 'Die Gruppe ist ungültig.';
$string['error_invalid_cart'] = 'Der Warenkorb ist ungültig.';
$string['error_no_payment_accounts_available'] = 'Kein Zahlungskonto verfügbar.';
$string['error_no_payment_currency_available'] = 'Zahlungen können in keiner Währung durchgeführt werden. Bitte stellen Sie sicher, dass mindestens ein Zahlungsgateway aktiv ist.';
$string['error_no_payment_gateway_available'] = 'Kein Zahlungsgateway verfügbar. Bitte geben Sie sowohl Zahlungskonto als auch Währung an, bevor Sie ein Gateway auswählen.';
$string['error_status_no_payment_account'] = 'Einschreibung über Warenkorb kann nicht aktiviert werden, ohne ein Zahlungskonto anzugeben.';
$string['error_status_no_payment_currency'] = 'Einschreibung über Warenkorb kann nicht aktiviert werden, ohne eine Zahlungswährung anzugeben.';

$string['event_cart_deleted'] = 'Warenkorb geleert';
$string['fixed'] = 'Fester Betrag';
$string['free'] = 'Kostenlos';
$string['gateway_wait'] = 'Bitte warten...';
$string['instructions'] = 'Anweisungen zur Einschreibungsseite';

$string['msg_cart_cancel_failed'] = 'Es gab ein Problem mit Ihrem Warenkorb.';
$string['msg_cart_cancel_success'] = 'Ihr Warenkorb wurde storniert.';
$string['msg_cart_changed'] = 'Artikel oder der zu zahlende Betrag im Warenkorb wurden geändert.';
$string['msg_cart_edit_blocked'] = 'Der Warenkorb kann derzeit nicht bearbeitet werden.';
$string['msg_enrolment_already'] = 'Sie sind bereits für den Kurs "{$a->title}" eingeschrieben.';
$string['msg_enrolment_deleted'] = 'Eine der Kurseinschreibungen wurde gelöscht.';
$string['msg_enrolment_failed'] = 'Es gab ein Problem mit Ihrer Einschreibung.';
$string['msg_enrolment_success'] = 'Ihre Einschreibung für die untenstehenden Kurse wurde erfolgreich abgeschlossen.';

$string['my_purchases'] = 'Meine Einkäufe';
$string['never'] = 'Nie';
$string['no_discount'] = 'Kein Rabatt';
$string['no_items'] = 'Keine Artikel gefunden.';
$string['not_delete_cart_with_payment_record'] = 'Warenkörbe mit Zahlungsdatensätzen nicht löschen';
$string['not_delete_cart_with_payment_record_desc'] = 'Wenn aktiviert, werden Warenkörbe mit Einträgen in der Zahlungstabelle nicht gelöscht.';
$string['one_day'] = 'Ein Tag';
$string['one_month'] = 'Ein Monat';
$string['order'] = 'Bestellung';
$string['order_id'] = 'Bestell-ID';
$string['pay'] = 'Bezahlen';
$string['payable'] = 'Zu zahlen';
$string['payment'] = 'Zahlung';
$string['payment_account'] = 'Zahlungskonto';
$string['payment_account_help'] = 'Zahlungen werden auf dieses Konto eingezahlt.';
$string['payment_completion_time'] = 'Zahlungsabschlusszeit';
$string['payment_completion_time_desc'] =
    'Definiert die maximale Zeit nach Beginn einer Zahlung, in der der Benutzer sie abschließen kann. Während dieser Zeit werden Warenkorb, Betrag und Gutscheine gesperrt.';
$string['payment_currency'] = 'Währungseinheit';
$string['pending_payment_cart_lifetime'] = 'Aufbewahrungszeit für Warenkörbe mit ausstehender Zahlung';
$string['pending_payment_cart_lifetime_desc'] =
    'Warenkörbe mit ausstehender Zahlung werden nach dem angegebenen Zeitraum dauerhaft gelöscht. Ein Wert von null bedeutet unbegrenzt.';
$string['percentage'] = 'Prozentsatz';
$string['pluginname'] = 'Warenkorb';
$string['pluginname_desc'] =
    'Die Warenkorb-Einschreibungsmethode erstellt einen systemweiten Warenkorb, der Benutzern das Hinzufügen und Kaufen von Kursen ermöglicht.';
$string['price'] = 'Preis';

$string['privacy:metadata:enrol_cart'] = 'Details der Warenkörbe, die für Einschreibungen verwendet werden.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'Zeitstempel, wann der Warenkorb zur Kasse ging.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'Der verwendete Gutscheincode, falls vorhanden.';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'Die ID des verwendeten Gutscheins, falls vorhanden.';
$string['privacy:metadata:enrol_cart:created_at'] = 'Zeitstempel der Erstellung des Warenkorbs.';
$string['privacy:metadata:enrol_cart:currency'] = 'Verwendete Währung im Warenkorb.';
$string['privacy:metadata:enrol_cart:payable'] = 'Gesamtbetrag, der im Warenkorb zu zahlen ist.';
$string['privacy:metadata:enrol_cart:price'] = 'Gesamtpreis des Warenkorbs.';
$string['privacy:metadata:enrol_cart:status'] = 'Status des Warenkorbs (z. B. ausstehend, abgeschlossen).';
$string['privacy:metadata:enrol_cart:user_id'] = 'ID des Benutzers, der dem Warenkorb zugeordnet ist.';
$string['privacy:metadata:enrol_cart_items'] = 'Details der Artikel in einem Warenkorb.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'ID des Warenkorbs, der den Artikel enthält.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'ID der Einschreibungsinstanz des Artikels.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'Zu zahlender Betrag für den Artikel.';
$string['privacy:metadata:enrol_cart_items:price'] = 'Preis des Artikels.';
$string['privacy:metadata:reason'] = 'Das Plugin enrol_cart speichert keine Benutzerdaten direkt.';

$string['proceed_to_checkout'] = 'Zur Kasse gehen';
$string['select_payment_method'] = 'Zahlungsmethode auswählen';
$string['six_months'] = 'Sechs Monate';
$string['status'] = 'Einschreibung über Warenkorb aktivieren';
$string['status_canceled'] = 'Storniert';
$string['status_checkout'] = 'Zur Kasse';
$string['status_current'] = 'Aktiv';
$string['status_delivered'] = 'Geliefert';
$string['status_desc'] = 'Ermöglicht Benutzern standardmäßig, Kurse in den Warenkorb zu legen.';
$string['three_months'] = 'Drei Monate';
$string['total'] = 'Gesamt';
$string['total_order_amount'] = 'Gesamtbetrag';
$string['unknown'] = 'Unbekannt';
$string['unlimited'] = 'Unbegrenzt';
$string['user'] = 'Benutzer';
$string['verify_payment_on_delivery'] = 'Endbetrag mit Zahlung bei Lieferung abgleichen';
$string['verify_payment_on_delivery_desc'] =
    'Wenn aktiviert, wird der Endbetrag des Warenkorbs mit dem gezahlten Betrag bei Lieferung verglichen. Die Lieferung erfolgt nur, wenn die Beträge übereinstimmen.';
$string['view'] = 'Anzeigen';
