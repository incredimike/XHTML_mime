# XHTML_mime

A [CodeIgniter][ci_url] hook class that allows you to send XHTML documents as the "application/xhtml+xml" mime-type to those browsers who support and prefer it. For all other browsers who do not support (or care not to receive) the "application/xhtml+xml" mime-type, the "text/html" mime-type is used.

This class also takes care of declaring the proper DOCTYPE depending on the situation; XHTML 1.1 is sent for "application/xhtml+xml", and HTML 4.01 for "text/html". 

But what about XHTML end-tags in my XHTML, you might ask? Those are re-written from "/>" to ">" when using the "text/html" mime-type.


## Installation 

1.  Ensure that you enable the use of hooks in `application/config/config.php`

        $config['enable_hooks'] = TRUE;

2.  Place `XHTML_mime.php` into your hooks directory. This is likely `application/hooks/`

3.  Add the following code to the hooks config file, located at `application/config/hooks.php`

    Code:

        $hook['display_override'] = array(
                                'class'    => 'XHTML_mime',
                                'function' => 'display',
                                'filename' => 'XHTML_mime.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

4.  Voila! You're done. Now CodeIgniter will start serving XHTML to User Agents who prefer to receive it as "application/xhtml+xml".

**Important Note:**
Since this class takes care of appending both DOCTYPE and HTML tags to the top of your HTML output, you need not add them yourself to your views. Please ensure you remove all <DOCTYPE> declarations, as well as <HTML> tags from your views.


## License:

cake is released under [Creative Commons Attribution 3.0 Unported][license_url].

## Author:

## **Mike Walker**
* Blog: [incredimike.com][blog_url]
* Twitter: [@incredimike][twitter_url]



[twitter_url]: http://www.twitter.com/incredimike
[blog_url]: http://www.incredimike.com/
[license_url]: http://creativecommons.org/licenses/by/3.0/
[ci_url]: http://www.codeigniter.com/

