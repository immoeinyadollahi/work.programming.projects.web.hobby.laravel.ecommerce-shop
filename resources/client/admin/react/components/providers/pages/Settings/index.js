import Logo from "./Logo";
import Slideshow from "./Slideshow";

export default {
  provides: "pages.settings",
  components: [
    ["logo", Logo],
    ["slideshow", Slideshow],
  ],
};
