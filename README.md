# UltraVulture WordPress Theme

Child theme of Twenty Sixteen.

This bundles parent CSS and extends with Sass.
To compile CSS and update versioning for CDN:

## Compiling
cd themes/ultravulture_t16
nvm use 18

Modify package.json to updated the output filename for the .min variant.

`npm run sass`

This will output both `style.css` (uncompressed) and `style_SOMEVERSION.min.css`

Update `functions.php`, look for this section and change the path.

```
add_filter('stylesheet_uri', function() {
    return  'https://d3lelize76uef8.cloudfront.net/style_20230415.min.css';
}, 10, 2);
```

I don't have a good automation for this yet to allow for automated deployment.
