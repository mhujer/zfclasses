Mhujer_View_Helper_Email
================================
Helps you to obfuscate an e-mail address

API
--------
```php
    /**
     * Obfuscates an e-mail address
     *
     * @param string $address E-mail address to obfuscate
     * @param boolean $mailto Generate mailto link?
     * @return string
     */
    public function email($address, $mailto = false)
    {
```

Use
--------
```php
echo $this->email('somebody@somewhere.sometld');

//will print "somebody&#64;<!---->somewhere.sometld"
```
```php
echo $this->email('somebody@somewhere.sometld', true);
//will print "<a href="mailto:somebody&#64;somewhere.sometld">somebody&#64;<!---->somewhere.sometld</a>"
```