function collectionItem() {
	this.visible = ko.observable(true);
	this.toggle = function() {
		this.visible(!this.visible());
	}
}

function newItem(el) {
	self = this;
	self.items = ko.observableArray([{rows: ['cake']}]);
	self.fillable = [];
	model = el.getAttribute('data-model');
	self.init = function() {
		$.getJSON('/api/fillable/'+model, function(data) {
			data.forEach(function (datum) {
				self.fillable.push(datum);
			});
		});
	};
	self.addItem = function() {
		self.items.push({
			rows: self.fillable
		});
	};
	self.removeItem = function() {
		self.items.remove(this);
	};
	self.debug = function() {
		console.log(self.items());
	};
}

document.querySelectorAll('.collection').forEach(function (el) {
	ko.applyBindings(new collectionItem(), el);
});

document.querySelectorAll('.new-collection').forEach(function (el) {
	elItem = new newItem(el);
	ko.applyBindings(elItem, el);
	elItem.init();
});