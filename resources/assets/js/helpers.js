/**
 * String prototype method used to truncate strings to n characters. UseWordBoundary indicates whether or not the last
 * word should remain intact or be cut off and ellipsis appended
 *
 * @param n int
 * @param useWordBoundary bool
 * @returns {*}
 */
String.prototype.trunc = function(n, useWordBoundary) {
    if (this.length <= n) { return this; }
    let subString = this.substr(0, n-1);
    return (useWordBoundary
        ? subString.substr(0, subString.lastIndexOf(' '))
        : subString) + "...";
}


/**
 * 'Newline to break'
 *
 * String prototype method used to convert newline characters to HTML line breaks. Similar to the PHP nl2br() method.
 *
 * @returns {string}
 */
String.prototype.nl2br = function() {
    return this.replace(/(?:\r\n|\r|\n)/g, '<br>')
}


Array.prototype.last = function(property = null) {
    const length = this.length - 1,
          end = this.slice(length)
          result = end.shift();
    
    if (property) return result[property];
    
    return result;
}

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}