const mix = require("laravel-mix");

mix.setPublicPath("../../../public/main/dist").disableNotifications();

require("./scss-config");
require("./react-config");
