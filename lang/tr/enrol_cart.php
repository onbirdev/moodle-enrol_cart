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
$string['a_week'] = 'Bir hafta';
$string['add_to_cart'] = 'Sepete ekle';
$string['add_to_group'] = 'Gruba ekle';
$string['apply'] = 'Uygula';
$string['assign_role'] = 'Kullanıcı rolü';
$string['assign_role_desc'] = 'Ödeme ve kayıttan sonra kullanıcılara atanacak rol.';
$string['availability'] = 'Kullanılabilirlik koşulları';
$string['availability_help'] = 'Sepet üzerinden kimlerin kayıt olabileceğini kısıtlayın.';
$string['cancel'] = 'İptal et';
$string['cancel_cart'] = 'İptal et';
$string['canceled_cart_lifetime'] = 'İptal edilmiş sepetin saklama süresi';
$string['canceled_cart_lifetime_desc'] =
    'Belirtilen süreden sonra iptal edilen sepetler kalıcı olarak silinir. 0 değeri sınırsız anlamına gelir.';

$string['cart:config'] = 'Sepet kayıt örneklerini yapılandır';
$string['cart:manage'] = 'Kayıtlı kullanıcıları yönet';
$string['cart:unenrol'] = 'Kullanıcıyı dersten kayıttan çıkar';
$string['cart:unenrolself'] = 'Kendini dersten kayıttan çıkar';
$string['cart:view'] = 'Alışveriş sepetini görüntüle';

$string['cart_is_empty'] = 'Sepetiniz boş';
$string['cart_status'] = 'Durum';
$string['checkout'] = 'Satın al';
$string['choose_gateway'] = 'Ödeme ağ geçidini seç:';
$string['complete_purchase'] = 'Satın almayı tamamla';
$string['convert_irr_to_irt'] = 'IRR’yi Tümen’e çevir';
$string['convert_irr_to_irt_desc'] =
    'Etkinleştirilirse, İran Riyali tutarları görüntüleme amacıyla Tümen olarak gösterilir. <b>(Bu ayar yalnızca kullanıcıya gösterilen değeri etkiler; kayıt yöntemlerini oluştururken veya düzenlerken tutarlar Riyal olarak girilmelidir.)</b>';
$string['convert_numbers_to_persian'] = 'İngilizce sayıları Farsçaya çevir';
$string['convert_numbers_to_persian_desc'] =
    'Etkinleştirilirse, tutarlar görüntülenirken İngilizce rakamlar Farsça rakamlara dönüştürülür.';
$string['cost'] = 'Ücret';
$string['cost_help'] = 'Kurs fiyatı 0’dan başlayabilir. 0 değeri kursun ücretsiz olduğunu belirtir.';
$string['coupon_class'] = 'İndirim kuponu sınıfı';
$string['coupon_class_desc'] =
    'İndirim kuponu sınıf yolunu belirtin. Örnek: <code dir="ltr">local_coupon\object\coupon</code>. Kupon sınıfı <code dir="ltr">enrol_cart\local\object\coupon_interface</code> arayüzünü uygulamalıdır.';
$string['coupon_code'] = 'Kupon kodu';
$string['coupon_discount'] = 'Kupon indirimi';
$string['coupon_enable'] = 'İndirim kuponlarını etkinleştir';
$string['coupon_enable_desc'] =
    'Uygun bir kupon eklentisi yüklüyse alışveriş sepeti indirim kuponlarını destekler.';
$string['currency'] = 'Para birimi';
$string['date'] = 'Tarih';
$string['delete_expired_carts'] = 'Süresi dolan sepetleri sil';
$string['discount'] = 'İndirim';
$string['discount_amount'] = 'İndirim tutarı';
$string['discount_type'] = 'İndirim türü';
$string['enable_guest_cart'] = 'Misafirlerin sepete kurs eklemesine/çıkarmasına izin ver';
$string['enable_guest_cart_desc'] =
    'Etkinleştirilirse, misafir kullanıcılar sepete kurs ekleyebilir ve gerekirse kaldırabilir.';

$string['enrol_end_date'] = 'Kayıt bitiş tarihi';
$string['enrol_end_date_help'] = 'Etkinleştirilirse, kullanıcılar bu tarihe kadar kayıt olabilir.';
$string['enrol_instance_defaults'] = 'Varsayılan kayıt ayarları';
$string['enrol_instance_defaults_desc'] = 'Yeni kurslara kayıt için varsayılan ayarlar';
$string['enrol_period'] = 'Kayıt süresi';
$string['enrol_period_desc'] = 'Kullanıcıların kursta kayıtlı kalacağı süre. 0 sınırsız demektir.';
$string['enrol_period_help'] = 'Kayıt sonrası kullanıcının kursta kalacağı süre. 0 sınırsız demektir.';
$string['enrol_start_date'] = 'Kayıt başlangıç tarihi';
$string['enrol_start_date_help'] = 'Etkinleştirilirse, kullanıcılar bu tarihten itibaren kayıt olabilir.';
$string['error_cost'] = 'Tutar bir sayı olmalıdır.';
$string['error_coupon_apply_failed'] = 'İndirim kodu uygulanamadı.';
$string['error_coupon_class_not_found'] = 'İndirim kuponu sınıfı bulunamadı.';
$string['error_coupon_class_not_implemented'] = 'İndirim kuponu sınıfı doğru uygulanmamış.';
$string['error_coupon_disabled'] = 'İndirim kodu devre dışı.';
$string['error_coupon_is_invalid'] = 'İndirim kodu geçersiz.';
$string['error_disabled'] = 'Sepet devre dışı.';
$string['error_discount_amount_is_higher'] = 'İndirim tutarı orijinal fiyattan fazla olamaz.';
$string['error_discount_amount_is_invalid'] = 'İndirim tutarı geçersiz.';
$string['error_discount_amount_must_be_a_number'] = 'İndirim tutarı bir sayı olmalıdır.';
$string['error_discount_amount_percentage_is_invalid'] = 'İndirim yüzdesi 0 ile 100 arasında olmalıdır.';
$string['error_discount_type_is_invalid'] = 'İndirim türü geçersiz.';
$string['error_enrol_end_date'] = 'Kayıt bitiş tarihi başlangıç tarihinden önce olamaz.';
$string['error_gateway_is_invalid'] = 'Seçilen ödeme ağ geçidi geçersiz.';
$string['error_group_is_invalid'] = 'Grup geçersiz.';
$string['error_invalid_cart'] = 'Sepet geçersiz.';
$string['error_no_payment_accounts_available'] = 'Kullanılabilir ödeme hesabı yok.';
$string['error_no_payment_currency_available'] = 'Ödeme yapılabilecek para birimi yok. En az bir aktif ödeme ağ geçidi olduğundan emin olun.';
$string['error_no_payment_gateway_available'] = 'Kullanılabilir ödeme ağ geçidi yok. Lütfen ödeme hesabı ve para birimini belirleyin.';
$string['error_status_no_payment_account'] = 'Sepet ile kayıt, ödeme hesabı belirtilmeden etkinleştirilemez.';
$string['error_status_no_payment_currency'] = 'Sepet ile kayıt, ödeme para birimi belirtilmeden etkinleştirilemez.';

$string['event_cart_deleted'] = 'Sepet temizlendi';
$string['fixed'] = 'Sabit tutar';
$string['free'] = 'Ücretsiz';
$string['gateway_wait'] = 'Lütfen bekleyin...';
$string['instructions'] = 'Kayıt sayfası talimatları';

$string['msg_cart_cancel_failed'] = 'Sepet işleminizde bir sorun oluştu.';
$string['msg_cart_cancel_success'] = 'Sepetiniz iptal edildi.';
$string['msg_cart_changed'] = 'Sepetteki öğe(ler) veya ödenecek tutar değişti.';
$string['msg_cart_edit_blocked'] = 'Şu anda sepet düzenlenemez.';
$string['msg_enrolment_already'] = '"{$a->title}" kursuna zaten kayıtlısınız.';
$string['msg_enrolment_deleted'] = 'Bir kurs kaydı silindi.';
$string['msg_enrolment_failed'] = 'Kayıt işleminizde bir sorun oluştu.';
$string['msg_enrolment_success'] = 'Aşağıdaki kurslara kaydınız başarıyla tamamlandı.';

$string['my_purchases'] = 'Satın almalarım';
$string['never'] = 'Asla';
$string['no_discount'] = 'İndirim yok';
$string['no_items'] = 'Öğe bulunamadı.';
$string['not_delete_cart_with_payment_record'] = 'Ödeme kaydı olan sepetleri silme';
$string['not_delete_cart_with_payment_record_desc'] = 'Etkinleştirilirse, ödeme tablosunda kaydı olan sepetler silinmez.';
$string['one_day'] = 'Bir gün';
$string['one_month'] = 'Bir ay';
$string['order'] = 'Sipariş';
$string['order_id'] = 'Sipariş ID';
$string['pay'] = 'Öde';
$string['payable'] = 'Ödenecek';
$string['payment'] = 'Ödeme';
$string['payment_account'] = 'Ödeme hesabı';
$string['payment_account_help'] = 'Ödemeler bu hesaba aktarılacaktır.';
$string['payment_completion_time'] = 'Ödeme tamamlama süresi';
$string['payment_completion_time_desc'] =
    'Bu ayar, kullanıcı ödeme işlemini başlattıktan sonra tamamlaması gereken maksimum süreyi belirler. Bu sürede sepet öğeleri, tutar ve indirim kodu ödeme için kilitlenir.';
$string['payment_currency'] = 'Para birimi';
$string['pending_payment_cart_lifetime'] = 'Bekleyen ödemeli sepet saklama süresi';
$string['pending_payment_cart_lifetime_desc'] =
    'Bekleyen ödemeli sepetler belirtilen süreden sonra kalıcı olarak silinir. 0 değeri sınırsız anlamına gelir.';
$string['percentage'] = 'Yüzde';
$string['pluginname'] = 'Alışveriş Sepeti';
$string['pluginname_desc'] =
    'Alışveriş sepeti kayıt yöntemi, kullanıcıların kursları sepete ekleyip satın almasına olanak tanır.';
$string['price'] = 'Fiyat';

$string['privacy:metadata:enrol_cart'] = 'Kayıt için kullanılan alışveriş sepetlerinin detayları.';
$string['privacy:metadata:enrol_cart:checkout_at'] = 'Sepet ödeme işleminin gerçekleştiği zaman.';
$string['privacy:metadata:enrol_cart:coupon_code'] = 'Sepette kullanılan kupon kodu (varsa).';
$string['privacy:metadata:enrol_cart:coupon_id'] = 'Sepette kullanılan kuponun kimliği (varsa).';
$string['privacy:metadata:enrol_cart:created_at'] = 'Sepetin oluşturulduğu zaman.';
$string['privacy:metadata:enrol_cart:currency'] = 'Sepette kullanılan para birimi.';
$string['privacy:metadata:enrol_cart:payable'] = 'Sepette ödenecek toplam tutar.';
$string['privacy:metadata:enrol_cart:price'] = 'Sepetin toplam fiyatı.';
$string['privacy:metadata:enrol_cart:status'] = 'Sepet durumu (örneğin beklemede, tamamlandı).';
$string['privacy:metadata:enrol_cart:user_id'] = 'Sepetle ilişkili kullanıcının kimliği.';
$string['privacy:metadata:enrol_cart_items'] = 'Bir alışveriş sepetindeki öğelerin detayları.';
$string['privacy:metadata:enrol_cart_items:cart_id'] = 'Öğeyi içeren sepetin kimliği.';
$string['privacy:metadata:enrol_cart_items:instance_id'] = 'Öğe ile ilişkili kayıt örneğinin kimliği.';
$string['privacy:metadata:enrol_cart_items:payable'] = 'Öğe için ödenecek tutar.';
$string['privacy:metadata:enrol_cart_items:price'] = 'Öğenin fiyatı.';
$string['privacy:metadata:reason'] = 'enrol_cart eklentisi doğrudan kullanıcı verisi saklamaz.';

$string['proceed_to_checkout'] = 'Satın almaya devam et';
$string['select_payment_method'] = 'Ödeme yöntemini seç';
$string['six_months'] = 'Altı ay';
$string['status'] = 'Alışveriş sepeti ile kayıt etkinleştir';
$string['status_canceled'] = 'İptal edildi';
$string['status_checkout'] = 'Ödeme';
$string['status_current'] = 'Aktif';
$string['status_delivered'] = 'Teslim edildi';
$string['status_desc'] = 'Kullanıcıların varsayılan olarak kursları sepete eklemesine izin verir.';
$string['three_months'] = 'Üç ay';
$string['total'] = 'Toplam';
$string['total_order_amount'] = 'Toplam tutar';
$string['unknown'] = 'Bilinmiyor';
$string['unlimited'] = 'Sınırsız';
$string['user'] = 'Kullanıcı';
$string['verify_payment_on_delivery'] = 'Teslimatta ödeme tutarını doğrula';
$string['verify_payment_on_delivery_desc'] =
    'Etkinleştirilirse, sepetin son tutarı teslimattaki ödeme tutarıyla karşılaştırılır. Tutarlarsa sepet teslim edilir.';
$string['view'] = 'Görüntüle';
