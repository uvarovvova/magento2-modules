define([
		"jquery",
		"mage/url",
		"mage/mage",
		"Magento_Ui/js/modal/modal"
	], function ($, urlBuilder) {

		var options = {

			buttons: [{
				text: "Request Price",
				class: 'action submit primary',
				click: function () {
					var form = $('#price-form');
					form.mage('validation', {});

					var status = form.validation('isValid');
					if (status) {
						PriceModal.getPrice(form.serialize());
					}

				}
			}],
			title: 'Request price',
			focus: '#username'
		};

		var optionResponse = {

			buttons: [{
				text: "Close",
				class: 'action primary',
				click: function () {
					this.modal('closeModal')
				}
			}],
			title: 'Response'
		};

		var PriceModal = {
			initModal: function (config, element) {

				$target = $(config.target);
				$target.modal(options);
				$element = $(element);
				$element.click(function () {
					$target.modal('openModal');
				});
			},

			getPrice: function (formData) {

				$.ajax({
					showLoader: true,
					url: urlBuilder.build('price/index/send'),
					data: formData,
					type: 'post',
					dataType: 'json',
					success: function (response) {

						var message = response && response.message;

						if (message) {

							if (response.status === true) {
								$target.modal('closeModal');
								$('#price-form')[0].reset();

								$(".price-response").html(message).modal(optionResponse).modal('openModal');
							} else {
								$target.modal('closeModal');

								$(".price-response").html(message).modal(optionResponse).modal('openModal');
							}
						}
					},
					error: function (xhr) {

					}
				});
			}
		};

		return {
			'price-modal-key': PriceModal.initModal
		};
	}
);