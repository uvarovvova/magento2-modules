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

			return storage.get('/notifications')
				.done(function (response) {
					self.notifications(response.items);
				})
				.fail(function (response) {
					console.log(response);
				})
		}
	});
});