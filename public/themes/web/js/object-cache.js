function ObjectCache()
{
    this._cache = {};
}

ObjectCache.prototype.set = function(key, value) {
    this._cache[key] = value;
};

ObjectCache.prototype.get = function(key) {
    return this._cache[key];
};

ObjectCache.prototype.objectExist = function(key) {
    return this.get(key) !== undefined;
};
