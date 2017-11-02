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

ko.extenders.format = function(target, parameters) {
  var result = ko.pureComputed({
    read: target,
    write: function(newValue) {
			var locale = {};
			$.ajaxSettings.async = false;
			$.getJSON('https://restcountries.eu/rest/v1/alpha/'+parameters.countryCode, function(data) {
				locale = data;
			});
			$.ajaxSettings.async = true;
      var current = target();
			var formatting = {
			  style: parameters.style,
			  minimumFractionDigits: parameters.digits,
				maximumFractionDigits: parameters.digits
			};
			var language = parameters.countryCode;
			if (locale.languages[0] == 'en') {
				var language = 'en-'+parameters.countryCode;
			}
			if (parameters.style == "currency") {
				formatting.currency = locale.currencies[0];
			}
			var newNumber = newValue.replace(/[^\d\.]+/g, '');
			if (isNaN(parseFloat(newNumber))) {
				newNumber = 0;
			}
      var valueToWrite = new Intl.NumberFormat(language, formatting).format(newNumber);
      if (valueToWrite !== current) {
        target(valueToWrite);
      } else {
        if (newValue !== current) {
          target.notifySubscribers(valueToWrite);
        }
      }
    }
  });

  result(target());
  return result;
};

function collectionItem(objectViewerModel) {
	this.visible = ko.observable(true);
	this.toggle = function() {
		this.visible(!this.visible());
	}
	this.objectViewerModel = objectViewerModel;
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

document.querySelectorAll('[name]').forEach(function (el) {
	var name = el.getAttribute('name').replace('.', '__');
	objectViewer[name] = el.textContent;
	var binding = 'value: objectViewerModel.'+name;
	if (el.hasAttribute('data-format')) {
		binding += '.extend({format: {'+el.getAttribute('data-format')+'}})';
	}
	el.setAttribute('data-bind', binding);
});

if (typeof(objectViewer) !== 'undefined') {
	var objectViewerModel = ko.mapping.fromJS(objectViewer);
	document.querySelectorAll('.exists').forEach(function (el) {
		ko.applyBindings(objectViewerModel, el);
	});
	document.querySelectorAll('[name]').forEach(function (el) {
		ko.applyBindings(objectViewerModel, el);
	});
}

document.querySelectorAll('.collection').forEach(function (el) {
	ko.cleanNode(el);
	ko.applyBindings(new collectionItem(objectViewerModel), el);
});

document.querySelectorAll('.new-collection').forEach(function (el) {
	ko.applyBindings(elItem = new newItem(el), el);
	elItem.init();
});
