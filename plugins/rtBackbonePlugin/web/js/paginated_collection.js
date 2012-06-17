(function(){

  // includes bindings for fetching/fetched
  Backbone.PaginatedCollection = Backbone.Collection.extend({
    //initialize: function() {
    //  _.bindAll(this, 'parse', 'url', 'pageInfo', 'nextPage', 'previousPage');
    //},
    page: 1,
    perPage: 25,
    total: 0,
    fetch: function(options) {
      options || (options = {});
      this.trigger("fetching");
      var self = this;
      var success = options.success;
      options.success = function(resp) {
        self.trigger("fetched");
        if(success) { success(self, resp); }
      };
      Backbone.Collection.prototype.fetch.call(this, options);
    },
    parse: function(resp) {
      this.page = resp.page;
      this.perPage = resp.perPage;
      this.total = resp.total;
      return resp.entries;
    },
    url: function() {
       return this.urlBase + '?' + $.param({page: this.page, perPage: this.perPage});
    },
    pageInfo: function() {
      var info = {
        total: this.total,
        page: this.page,
        perPage: this.perPage,
        pages: Math.ceil(this.total / this.perPage),
        prev: false,
        next: false
      };

      var max = Math.min(this.total, this.page * this.perPage);

      if (this.total == this.pages * this.perPage) {
        max = this.total;
      }

      info.range = [(this.page - 1) * this.perPage + 1, max];

      if (this.page > 1) {
        info.prev = this.page - 1;
      }

      if (this.page < info.pages) {
        info.next = this.page + 1;
      }

      return info;
    },
    nextPage: function() {
      this.page = this.page + 1;
      this.fetch();
    },
    previousPage: function() {
      this.page = this.page - 1;
      this.fetch();
    }
  });

}).call(this);