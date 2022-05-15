import "vite/dynamic-import-polyfill";
// ---------------------- CSS MYSELF ----------------------
import "./styles/index.scss";

// ---------------------- JS MYSELF ----------------------
import toggleSidbarMenuDropdown from "./scripts/toggleSidbarMenuDropdown";
import handleToggleDropdown from "./scripts/toggleDropdown";
import toggleHiddenStickyMetaPost from "./scripts/toggleHiddenStickyMetaPost";
import toogleWilModal from "./scripts/toggleWilModal";
import toogleNightMode from "./scripts/toogleNightMode";
import _setBgColorForAvatar from "./scripts/wilBgAvatar";
import _newGlideCarousel from "./scripts/wilGlideCarousel";

//
import filterElementSection from "./scripts/filterElementSection";

//  will remove to PLUGIN
import { toggleBookmarkArticle } from "./scripts/_toggleBookmarkArticle";
import { toggleFollowUser } from "./scripts/_toggleFollowUser";
import { toggleLikeComment } from "./scripts/_toggleLikeComment";
import { _showCommentLists } from "./scripts/_showCommentLists";

function init() {
  try {
    toggleSidbarMenuDropdown();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    _showCommentLists();
  } catch (error) {
    console.log(error);
  }
  try {
    toggleHiddenStickyMetaPost();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    toggleLikeComment();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    toggleBookmarkArticle();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    toggleFollowUser();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    toogleNightMode();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    toogleWilModal();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    handleToggleDropdown();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    _setBgColorForAvatar();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    _newGlideCarousel();
  } catch (error) {
    console.log(error);
  }
  //
  try {
    filterElementSection();
  } catch (error) {
    console.log(error);
  }
}
init();
