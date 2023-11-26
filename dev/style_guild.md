# ThumpNet Style Guide

This is a set of rules that apply to the ThumpNet source code. And must be followed to find its way into the public release.

## HTML Guidelines
### Tags
* Void tags must follow XML/XHTML style. `<tag/>`
* Otherwise all tags must have the closing tags.
#### Void tags
* `<br/>`
* `<hr/>`
* `<img src=""/>`
* `<input/>`
* `<link/>`
* `<meta/>`
## File extensions
* HTML files must use the `.html` extension. If php is involed in this file, use `.php` instead.
* JavaSript files must always use `.js`.
* CSS files must always use `.css`.
* Config files must always use `.ini`.
## Strings
* String should ALWAYS be formatted with double-quotes. This makes strings consistant across languages.
* Do not change the type of quote used within a string. Always escape it.
## Scripts
* Scopes should always have their brackets on their own lines.
* If statements may omit the scope brackets. But this must be made consistant across all cases of the if statement. 
```js
// Acceptable
if(statement)
{
    a();
}
else
{
    b();
}

if(statement)
    a();
else
    b();

if(statement) a();
else b();

// Unacceptable
if(statement)
    a();
else
{
    b();
}

if(statement)
    a();
else b();
```
## Tabs v. Spaces
You may mix and match tabs or spaces. Nothing is currently enforced reguarding this.

## Naming
Never use unclear naming. Always make it clear what a name belongs to.
For longer names. Use `snake_case`.

Example: `stylingimage` or `stylinglevelimage` are a bad classnames.
* Styling is implied from it being a class.
* Variables should be specific and in `snake_case`.

`level_card_thumbnail` would be a better classname.

## CSS Styling
* Inline styles should never use spaces between the colon and value of the property.
* Within `style` tags or in a stylesheet. Always include the space.
* Prefer css variables when values (such as colors) will be reused.
* Within `style` tags or in a stylesheet. Always include a comment with obscure selectors.

## End of file blank lines
Nothing is currently enforced.