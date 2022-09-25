const mix = require("laravel-mix");

mix.setPublicPath("../../../public/admin/dist").disableNotifications();

require("./scss-config");
require("./react-config");
