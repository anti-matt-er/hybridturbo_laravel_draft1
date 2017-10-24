String.prototype.ucwords = function() {
	str = this.toLowerCase();
	return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
	function(s){
		return s.toUpperCase();
	});
};

String.prototype.underscoreToWords = function() {
	str = this.replace('_', ' ');
	return str.ucwords();
};

function collectionItem() {
	this.visible = ko.observable(true);
	this.toggle = function() {
		this.visible(!this.visible());
	}
}

function newItem(el) {
	var self = this;
	self.items = ko.observableArray([]);
	self.editable = [];
	self.model = el.getAttribute('data-model');
	self.init = function() {
		$.getJSON('/api/editable/'+self.model, function(data) {
			data.forEach(function (datum) {
				self.editable.push(datum);
			});
		});
	};
	self.addItem = function() {
		self.items.push({
			rows: self.editable
		});
	};
	self.removeItem = function() {
		self.items.remove(this);
	};
}

document.querySelectorAll('.collection').forEach(function (el) {
	ko.applyBindings(new collectionItem(), el);
});

document.querySelectorAll('.new-collection').forEach(function (el) {
	ko.applyBindings(elItem = new newItem(el), el);
	elItem.init();
});