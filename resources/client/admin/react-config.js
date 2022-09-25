const path = require("path");

const mix = require("laravel-mix");

mix.js("react", "js/app.js")
    .extract()
    .react()
    .alias({
        $hooks: path.join(__dirname, "react/hooks"),
        $services: path.join(__dirname, "react/services"),
        $slices: path.join(__dirname, "react/slices"),
        $template: path.join(__dirname, "react/template"),
        $utilities: path.join(__dirname, "react/utilities"),
        $validations: path.join(__dirname, "react/validations"),
        $config: path.join(__dirname, "react/config"),
        $contexts: path.join(__dirname, "react/contexts"),
        $HOC: path.join(__dirname, "react/HOC"),
        $http: path.join(__dirname, "react/http"),
        $components: path.join(__dirname, "react/components"),
    });
