import $ from 'jquery';

const showPayable = (payable) => {
    let html = '<span class="bold text-danger">--</span>';
    const currencyName = $('#id_currency option:selected').text();

    if (typeof payable === 'number' && payable >= 0) {
        html =
            '<span class="currency bold text-success"><span>' +
            currencyName +
            '</span> &nbsp;' +
            payable.toLocaleString() +
            '</span>';
    }

    $('#fitem_id_payable .form-control-static').html(html);
};
const calcPayable = () => {
    let cost = $('#id_cost').val();
    const discountType = Number($('#id_customint1').val());
    let discountAmount = Number($('#id_customchar1').val());
    let payable = '';

    if ((cost = Number(cost))) {
        if (!discountType) {
            payable = cost;
        }

        if (discountType === 10 && discountAmount >= 0 && discountAmount <= 100) {
            discountAmount = (discountAmount * cost) / 100;
            payable = cost - discountAmount;
        }

        if (discountType === 20 && cost >= discountAmount) {
            payable = cost - discountAmount;
        }
    }

    showPayable(payable);
};

const toggleDiscountAmount = () => {
    const discountType = $('#id_customint1').val();
    $('#id_customchar1').attr('disabled', !(discountType == 10 || discountType == 20));
};

export const init = () => {
    $(document).on('change', '#id_customint1', toggleDiscountAmount);
    $(document).on('change', '#id_cost, #id_customint1, #id_customchar1', calcPayable);
    $(document).on('keyup', '#id_cost, #id_customchar1', calcPayable);

    toggleDiscountAmount();
    calcPayable();
};
