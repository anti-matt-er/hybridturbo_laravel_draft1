var order = new Vue({
  el: '.order',
  data: {
  	removed: false
  },
  methods: {
  	toggle() {
  		this.removed = !this.removed;
  	}
  }
});