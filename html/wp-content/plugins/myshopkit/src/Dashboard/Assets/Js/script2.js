jQuery(document).ready(function () {
    const iframe = document.getElementById("shopkit-iframe");

    function authen() {
        jQuery.ajax({
            data: {
                action: "mskpss_getCodeAuth", //Tên action, dữ liệu gởi lên cho server
            },
            method: "POST",
            url: ajaxurl,
            success: function (response) {
                iframe.addEventListener("load", function () {
                    iframe.contentWindow.postMessage(
                        {
                            payload: {
                                url: window.MYSHOOKITPSS_GLOBAL.restBase,
                                token: response.data.code,
                                tidioId: window.MYSHOOKITPSS_GLOBAL.tidio || "",
                                clientSite: window.MYSHOOKITPSS_GLOBAL.clientSite || "",
                                email: window.MYSHOOKITPSS_GLOBAL.email || "",
                                purchaseCode: window.MYSHOOKITPSS_GLOBAL.purchaseCode || "",
                                purchaseCodeLink: window.MYSHOOKITPSS_GLOBAL.purchaseCodeLink || "",
                                endpointVerification:
                                    window.MYSHOOKITPSS_GLOBAL.endpointVerification || "",
                            },
                            type: "@AjaxToken",
                        },
                        "*"
                    );
                    iframe.classList.remove("hidden");
                });
                if (iframe) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: {
                                url: window.MYSHOOKITPSS_GLOBAL.restBase,
                                token: response.data.code,
                                tidioId: window.MYSHOOKITPSS_GLOBAL.tidio || "",
                                clientSite: window.MYSHOOKITPSS_GLOBAL.clientSite || "",
                                email: window.MYSHOOKITPSS_GLOBAL.email || "",
                                purchaseCode: window.MYSHOOKITPSS_GLOBAL.purchaseCode || "",
                                purchaseCodeLink: window.MYSHOOKITPSS_GLOBAL.purchaseCodeLink || "",
                                endpointVerification:
                                    window.MYSHOOKITPSS_GLOBAL.endpointVerification || "",
                            },
                            type: "@AjaxToken",
                        },
                        "*"
                    );
                }
            },
            error: function (response) {
                iframe.addEventListener("load", function () {
                    iframe.contentWindow.postMessage(
                        {
                            payload: {
                                url: window.MYSHOOKITPSS_GLOBAL.restBase,
                                token: "",
                                tidioId: window.MYSHOOKITPSS_GLOBAL.tidio || "",
                                clientSite: window.MYSHOOKITPSS_GLOBAL.clientSite || "",
                                email: window.MYSHOOKITPSS_GLOBAL.email || "",
                                purchaseCode: window.MYSHOOKITPSS_GLOBAL.purchaseCode || "",
                                purchaseCodeLink: window.MYSHOOKITPSS_GLOBAL.purchaseCodeLink || "",
                                endpointVerification:
                                    window.MYSHOOKITPSS_GLOBAL.endpointVerification || "",
                            },
                            type: "@AjaxToken",
                        },
                        "*"
                    );
                    iframe.classList.remove("hidden");
                });
            },
        });
    }

    authen();


    window.addEventListener("message", (event) => {
        if (event.source !== iframe.contentWindow) {
            return;
        }
        const { payload, type } = event.data

        /** Dashboard page */
        if (type === "@HasPassed") {
            if (payload.hasPassed === true) {
                authen();
            }
        }
        // has item 
        if (type === "@Dashboard/getCampaignStatus/request") {
            console.log('@Dashboard/getCampaignStatus/request', payload);
        }

        // shop info
        if (type === "@Dashboard/getShopInfo/request") {
            console.log('@Dashboard/getShopInfo/request', payload);
        }

        // popup
        if (type === "@Dashboard/getPopupViews/request") {
            console.log('@Dashboard/getPopupViews/request', payload);
        }
        if (type === "@Dashboard/getPopupClicks/request") {
            console.log('@Dashboard/getPopupClicks/request', payload);
        }
        if (type === "@Dashboard/getPopupSubscribers/request") {
            console.log('@Dashboard/getPopupSubscribers/request', payload);
        }

        // smartbar
        if (type === "@Dashboard/getSmartbarViews/request") {
            console.log('@Dashboard/getSmartbarViews/request', payload);
        }
        if (type === "@Dashboard/getSmartbarClicks/request") {
            console.log('@Dashboard/getSmartbarClicks/request', payload);
        }
        if (type === "@Dashboard/getSmartbarSubscribers/request") {
            console.log('@Dashboard/getSmartbarSubscribers/request', payload);
        }

        // slide in
        if (type === "@Dashboard/getSlideInViews/request") {
            console.log('@Dashboard/getSlideInViews/request', payload);
        }
        if (type === "@Dashboard/getSlideInSubscribers/request") {
            console.log('@Dashboard/getSlideInSubscribers/request', payload);
        }
        if (type === "@Dashboard/getSlideInClicks/request") {
            console.log('@Dashboard/getSlideInClicks/request', payload);
        }

        /** Popup page */
        if (type === "@Popup/getItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_getPopups",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/getItems/success",
                        },
                        "*"
                    );

                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/getItems/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Popup/getItem/request") {
            console.log("@Popup/getItem/request", payload);
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_getPopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/getItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/getItem/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/addItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_addPopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/addItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/addItem/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/updateStatusItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_updateStatusPopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/updateStatusItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/updateStatusItem/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/deleteItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_deletePopups",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/deleteItems/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/deleteItems/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/updateTitleItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_updateTitlePopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/updateTitleItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/updateTitleItem/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/updateConfigItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_updateConfigPopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/updateConfigItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/updateConfigItem/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/getPopupTableData/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_getSubscribersPopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/getPopupTableData/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Popup/getPopupTableData/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/getPopupCSV/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_downloadSubscribersPopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/getPopupCSV/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/getPopupCSV/failure",
                        },
                        "*"
                    );
                },
            });
        }

        if (type === "@Popup/forceActivePopup/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_forceActivePopup",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Popup/forceActivePopup/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/forceActivePopup/failure",
                        },
                        "*"
                    );
                },
            });
        }

        /** Smartbar page */
        if (type === "@Smartbar/getItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_getSmartBars",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/getItems/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/getItems/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/getItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_getSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/getItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/getItem/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/addItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_addSmartBars",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/addItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/addItem/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/updateStatusItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_updateStatusSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/updateStatusItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/updateStatusItem/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/deleteItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_deleteSmartBars",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/deleteItems/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/deleteItems/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/updateTitleItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_updateTitleSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/updateTitleItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/updateTitleItem/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/updateConfigItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_updateConfigSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/updateConfigItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/updateConfigItem/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/getSmartbarTableData/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_getSubscribersSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/getSmartbarTableData/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/getSmartbarTableData/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/getSmartbarCSV/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_downloadSubscribersSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/getSmartbarCSV/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/getSmartbarCSV/failure",
                        },
                        "*"
                    );
                },
            });
        }
        if (type === "@Smartbar/forceActiveSmartbar/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "mskpss_forceActiveSmartBar",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Smartbar/forceActiveSmartbar/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                    iframe.contentWindow.postMessage(
                        {
                            payload: undefined,
                            type: "@Smartbar/forceActiveSmartbar/failure",
                        },
                        "*"
                    );
                },
            });
        }

        /** SlideIn page */
        if (type === "@SlideIn/getItems/request") {
            console.log("@SlideIn/getItems/request", payload);
        }
        if (type === "@SlideIn/getItem/request") {
            console.log("@SlideIn/getItem/request", payload);
        }
        if (type === "@SlideIn/addItem/request") {
            console.log("@SlideIn/addItem/request", payload);
        }
        if (type === "@SlideIn/updateStatusItem/request") {
            console.log("@SlideIn/updateStatusItem/request", payload);
        }
        if (type === "@SlideIn/deleteItems/request") {
            console.log("@SlideIn/deleteItems/request", payload);
        }
        if (type === "@SlideIn/updateTitleItem/request") {
            console.log("@SlideIn/updateTitleItem/request", payload);
        }
        if (type === "@SlideIn/updateConfigItem/request") {
            console.log("@SlideIn/updateConfigItem/request", payload);
        }
        if (type === "@SlideIn/getSlideInTableData/request") {
            console.log("@SlideIn/getSlideInTableData/request", payload);
        }
        if (type === "@SlideIn/getSlideInCSV/request") {
            console.log("@SlideIn/getSlideInCSV/request", payload);
        }
        if (type === "@SlideIn/forceActiveSlideIn/request") {
            console.log("@SlideIn/forceActiveSlideIn/request", payload);
        }

        /** Subscribers page */
        if (type === "@Subscriber/getSubscribersCSV/request") {
            console.log("@Subscriber/getSubscribersCSV/request", payload);
        }

        if (type === "@Subscriber/deleteManySubscribers/request") {
            console.log("@Subscriber/deleteManySubscribers/request", payload);
        }

        if (type === "@Subscriber/deleteOneSubscriber/request") {
            console.log("@Subscriber/deleteOneSubscriber/request", payload);
        }

        if (type === "@Subscriber/getTableSubscriber/request") {
            console.log("@Subscriber/getTableSubscriber/request", payload);
        }

    }, false);


    jQuery("#btn-Revoke-Purchase-Code").click(function () {
        // let status = confirm("Are you sure you want to revoke the Purchase Code?");
        // if (status) {
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: "mskpss_getPopups",
                purchaseCode: MYSHOOKITPSS_GLOBAL.purchaseCode,
            },
            success: function (response) {
                //location.reload();
            },
            error: function (jqXHR, error, errorThrown) {
                alert(jqXHR.responseJSON.message);
            },
        });
        //}
    })
});
