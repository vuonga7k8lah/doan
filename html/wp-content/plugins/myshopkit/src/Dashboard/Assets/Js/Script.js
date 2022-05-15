jQuery(document).ready(function () {
    const iframe = document.getElementById("shopkit-iframe");

    function authen() {
        jQuery.ajax({
            data: {
                action: "myshopkit_getCodeAuth", //Tên action, dữ liệu gởi lên cho server
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
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getCampaignStatus",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getCampaignStatus/success",
                        },
                        "*"
                    );

                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        // shop info
        if (type === "@Dashboard/getShopInfo/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getShopInfo",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getShopInfo/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        // popup
        if (type === "@Dashboard/getPopupViews/request") {
            console.log("getPopupViews",payload)
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getPopupViews",
                    params: {
                        ...payload,
                        postType: 'popup'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getPopupViews/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@Dashboard/getPopupClicks/request") {
            console.log("getPopupClicks",payload)
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getPopupClicks",
                    params: {
                        ...payload,
                        postType: 'popup'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getPopupClicks/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@Dashboard/getPopupSubscribers/request") {
            console.log("getPopupSubscribers",payload)
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getPopupSubscribers",
                    params: {
                        ...payload,
                        postType: 'popup'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getPopupSubscribers/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        // smartbar
        if (type === "@Dashboard/getSmartbarViews/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSmartBarViews",
                    params: {
                        ...payload,
                        postType: 'smartbar'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getSmartbarViews/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@Dashboard/getSmartbarClicks/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSmartBarClicks",
                    params: {
                        ...payload,
                        postType: 'smartbar'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getSmartbarClicks/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@Dashboard/getSmartbarSubscribers/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSmartBarSubscribers",
                    params: {
                        ...payload,
                        postType: 'smartbar'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getSmartbarSubscribers/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        // slide in
        if (type === "@Dashboard/getSlideInViews/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSlideInViews",
                    params: {
                        ...payload,
                        postType: 'slidein'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getSlideInViews/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@Dashboard/getSlideInSubscribers/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSlideInSubscribers",
                    params: {
                        ...payload,
                        postType: 'slidein'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getSlideInSubscribers/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@Dashboard/getSlideInClicks/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSlideInClicks",
                    params: {
                        ...payload,
                        postType: 'slidein'
                    },
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Dashboard/getSlideInClicks/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        /** Popup page */
        if (type === "@Popup/getItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getPopups",
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
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getPopup",
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
                },
            });
        }

        if (type === "@Popup/addItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_addPopup",
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
                },
            });
        }

        if (type === "@Popup/updateStatusItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateStatusPopup",
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
                },
            });
        }

        if (type === "@Popup/deleteItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_deletePopups",
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
                },
            });
        }

        if (type === "@Popup/updateTitleItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateTitlePopup",
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
                },
            });
        }

        if (type === "@Popup/updateConfigItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateConfigPopup",
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
                },
            });
        }

        if (type === "@Popup/getPopupTableData/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSubscribersPopup",
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
                },
            });
        }

        if (type === "@Popup/getPopupCSV/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_downloadSubscribersPopup",
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
                },
            });
        }

        if (type === "@Popup/forceActivePopup/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_forceActivePopup",
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
                },
            });
        }

        /** Smartbar page */
        if (type === "@Smartbar/getItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSmartBars",
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
                },
            });
        }
        if (type === "@Smartbar/getItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSmartBar",
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
                },
            });
        }
        if (type === "@Smartbar/addItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_addSmartBars",
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
                },
            });
        }
        if (type === "@Smartbar/updateStatusItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateStatusSmartBar",
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
                },
            });
        }
        if (type === "@Smartbar/deleteItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_deleteSmartBars",
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
                },
            });
        }
        if (type === "@Smartbar/updateTitleItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateTitleSmartBar",
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
                },
            });
        }
        if (type === "@Smartbar/updateConfigItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateConfigSmartBar",
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
                },
            });
        }
        if (type === "@Smartbar/getSmartbarTableData/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSubscribersSmartBar",
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
                },
            });
        }
        if (type === "@Smartbar/getSmartbarCSV/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_downloadSubscribersSmartBar",
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
                },
            });
        }
        if (type === "@Smartbar/forceActiveSmartbar/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_forceActiveSmartBar",
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
                },
            });
        }

        /** SlideIn page */
        if (type === "@SlideIn/getItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSlideIns",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/getItems/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/getItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/getItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/addItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_addSlideIns",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/addItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/updateStatusItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateStatusSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/updateStatusItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/deleteItems/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_deleteSlideIns",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/deleteItems/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/updateTitleItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateTitleSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/updateTitleItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/updateConfigItem/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_updateConfigSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/updateConfigItem/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/getSlideInTableData/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSubscribersSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/getSlideInTableData/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/getSlideInCSV/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_downloadSubscribersSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/getSlideInCSV/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        if (type === "@SlideIn/forceActiveSlideIn/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_forceActiveSlideIn",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@SlideIn/forceActiveSlideIn/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        /** Subscribers page */
        if (type === "@Subscriber/getSubscribersCSV/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSubscribersCSV",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Subscriber/getSubscribersCSV/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        if (type === "@Subscriber/deleteManySubscribers/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_deleteSubscribers",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Subscriber/deleteManySubscribers/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        if (type === "@Subscriber/deleteOneSubscriber/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_deleteSubscriber",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Subscriber/deleteOneSubscriber/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        if (type === "@Subscriber/getTableSubscriber/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getSubscribers",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Subscriber/getTableSubscriber/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        /** Shop Product*/
        if (type === "@Shop/getProducts/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getProducts",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Shop/getProducts/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }
        /** Shop Page*/
        if (type === "@Shop/getPages/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getPages",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Shop/getPages/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

        // shop discount
        if (type === "@Shop/getDiscounts/request") {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: "myshopkit_getDiscounts",
                    params: payload,
                },
                success: function (response) {
                    iframe.contentWindow.postMessage(
                        {
                            payload: response,
                            type: "@Shop/getDiscounts/success",
                        },
                        "*"
                    );
                },
                error: function (jqXHR, error, errorThrown) {
                    alert(jqXHR.responseJSON.message);
                },
            });
        }

    }, false);


    jQuery("#btn-Revoke-Purchase-Code").click(function () {
        // let status = confirm("Are you sure you want to revoke the Purchase Code?");
        // if (status) {
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: "myshopkit_getPopups",
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
