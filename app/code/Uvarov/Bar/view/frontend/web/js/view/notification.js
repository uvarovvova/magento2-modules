define([
	'uiComponent',
	'ko',
	'mage/url',
	'mage/storage'
], function (Component, ko, urlBuilder, storage) {
	return Component.extend({
		initialize: function () {
			this._super();

			this.getNotifications();
			this.loadNotifications();
		},
		getNotifications: function () {

			this.notifications = ko.observable();

		},
		loadNotifications: function () {

			var self = this;
			var url = urlBuilder.build('notifications/index/notifications');

			return storage.post(url, '')
				.done(
					function (responce) {
						self.notifications(responce.items);
					}
				).fail(
					function (responce) {
						console.log(responce);
					}
				)

		}
	});
});