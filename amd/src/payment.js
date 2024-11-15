import Notification from 'core/notification';

const processPayment = async(gateway, component, paymentArea, itemId, description) => {
    const paymentMethod = await import(`paygw_${gateway}/gateways_modal`);
    return paymentMethod.process(component, paymentArea, itemId, description);
};

export const init = (gateway, component, paymentArea, itemId, successUrl, description) => {
    if (!init.initialised) {
        init.initialised = true;

        processPayment(gateway, component, paymentArea, itemId, description)
            .then((message) => {
                Notification.addNotification({
                    message,
                    type: 'success',
                });

                setTimeout(() => {
                    location.href = successUrl;
                }, 2000);

                return message; // Satisfies eslint, although it's never reached
            })
            .catch((message) => {
                Notification.alert('', message);

                setTimeout(() => {
                    location.href = successUrl;
                }, 2000);
            });
    }
};

/**
 * Whether the init function was called before.
 *
 * @static
 * @type {boolean}
 */
init.initialised = false;
