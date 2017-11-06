ko.options.deferUpdates = true;

if (typeof countryCode === 'undefined') {
	var countryCode;
	$.ajax({
		type: 'GET',
		url: '/api/country',
		async: false,
		success: function(data) {
			countryCode = data;
		}
	});
}

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
			$.ajaxSettings.async = false;
			var regFirstDigits = /^.*?(?=\.)/g;
			var regStrip = /[^\d]*/g;
			var valueToWrite = ''+newValue;
			var current = target();
			var currentCountryCode = countryCode;
			if (typeof parameters.countryCode !== 'undefined') {
				currentCountryCode = parameters.countryCode;
			}
			if (parameters.style === 'integer') {
				valueToWrite = +(valueToWrite.replace(regStrip, ''));
			} else {
				var locale = {};
				$.getJSON('https://restcountries.eu/rest/v1/alpha/'+currentCountryCode, function(data) {
					locale = data;
				});
				var formatting = {
				  style: parameters.style,
				  minimumFractionDigits: parameters.digits,
					maximumFractionDigits: parameters.digits
				};
				var language = currentCountryCode;
				if (locale.languages[0] == 'en') {
					var language = 'en-'+currentCountryCode;
				}
				if (parameters.style == "currency") {
					formatting.currency = locale.currencies[0];
				}
				var parts = valueToWrite.split(regFirstDigits);
				var dotFirst = valueToWrite[0] == '.';
				var newNumber = '';
				if (1 in parts) {
					parts[0] = regFirstDigits.exec(valueToWrite);
				  if (0 in parts[0]) {
				  	parts[0] = parts[0][0];
				  }
				  parts[0] = parts[0].replace(regStrip, '');
				  parts[1] = parts[1].replace(regStrip, '');
				  newNumber = parts[0]+'.'+parts[1];
				} else {
					newNumber = parts[0].replace(regStrip, '');
				  if (dotFirst) {
				  	newNumber = '.'+newNumber;
				  }
				}
				if (isNaN(parseFloat(newNumber))) {
					newNumber = 0;
				}
	      valueToWrite = new Intl.NumberFormat(language, formatting).format(newNumber);
			}
      if (valueToWrite !== current) {
        target(valueToWrite);
      } else {
        if (newValue !== current) {
          target.notifySubscribers(valueToWrite);
        }
      }
			$.ajaxSettings.async = true;
    }
  }).extend({ notify: 'always' });;

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
		var toPush = {
			rows: self.editable,
			values: {}
		};
		self.editable.forEach(function (datum) {
			$.ajax({
				type: 'GET',
				url: '/api/format/'+self.model+'/'+datum+'/true',
				success: function(formatting) {
					if (formatting) {
						toPush.values[datum] = ko.observable('doge').extend({format: JSON.parse(formatting)});
					} else {
						toPush.values[datum] = ko.observable('simple doge');
					}
				},
				failure: function() {
					toPush.values[datum] = ko.observable('sad doge');
				}
			});
		});
		self.items.push(toPush);
	};
	self.removeItem = function() {
		self.items.remove(this);
	};
}

document.querySelectorAll('[data-format]').forEach(function (el) {
	if (!el.hasAttribute('data-bind')) {
		var nameExtractor = /^data\[(.*?)\]/g;
		var name = nameExtractor.exec(el.getAttribute('name'));
		console.log(name);
		if (1 in name) {
			name = name[1];
		} else {
			name = name[0];
		}
		name = name.replace('.', '__');
		console.log(name);
		objectViewer[name] = el.textContent;
		var binding = 'value: objectViewerModel.'+name;
	} else {
		// WORKS ONLY ON RIGHTMOST DECLARED BINDING
		var binding = el.getAttribute('data-bind');
	}
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
	document.querySelectorAll('[data-format]').forEach(function (el) {
		if (!ko.dataFor(el)) {
			ko.applyBindings(objectViewerModel, el);
		}
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
