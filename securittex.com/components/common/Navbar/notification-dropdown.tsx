import { darkModeToggle, darkModeToggleDashboard } from "helpers/functions";
import moment from "moment";
import useTranslation from "next-translate/useTranslation";
import Link from "next/link";
import { useRouter } from "next/router";
import React from "react";
import { BsFillMoonFill, BsFillSunFill } from "react-icons/bs";
import { HiArrowNarrowRight, HiUserCircle } from "react-icons/hi";
import { IoMdGlobe } from "react-icons/io";
import { RiNotificationBadgeLine } from "react-icons/ri";
import { useDispatch } from "react-redux";
import { LogoutAction } from "state/actions/user";

const NotificationDropdown = ({
  isLoggedIn,
  notificationData,
  seen,
  user,
  theme,
  settings,
  setTheme,
  setActive,
  active,
}: any) => {
  const dispatch = useDispatch();
  const { t } = useTranslation("common");
  const router = useRouter();
  return (
    <div className="">
      {isLoggedIn ? (
        <div className="cp-user-top-bar-right">
          <div>
            <ul>
              <li className="hm-notify" id="notification_item" style={{ margin: '0 10px' }}>
                <div className="btn-group profile-dropdown">
                  <button
                    type="button"
                    className="btn dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    style={{ marginLeft: '0' }}
                  >
                    <span className="cp-user-avater">
                      <span>
                        <HiUserCircle size={30} />
                      </span>
                      <span className="cp-user-avater-info"></span>
                    </span>
                  </button>
                  <div className="dropdown-menu dropdown-menu-right">
                    <p
                      className={`${user?.online_status?.online_status
                          ? "userActive"
                          : "userDeactive"
                        } big-user-thumb`}
                    >
                      <img
                        src={user?.photo}
                        className="img-fluid profile-avatar"
                        alt=""
                      />
                    </p>
                    <div className="user-name">
                      <p className="nav-userName">
                        {user?.first_name!} {user?.last_name!}
                      </p>
                    </div>
                    <Link href="/user/profile">
                      <button className="dropdown-item" type="button">
                        <a href="">
                          <i className="fa-regular fa-user"></i>
                          {t("Profile")}
                        </a>
                      </button>
                    </Link>
                    <Link href="/user/settings">
                      <button className="dropdown-item" type="button">
                        <a href="">
                          <i className="fa fa-cog"></i>
                          {t("My Settings")}
                        </a>
                      </button>
                    </Link>

                    <Link href="/user/my-wallet">
                      <button className="dropdown-item" type="button">
                        <a href="-wallet">
                          <i className="fa fa-credit-card"></i>
                          {t("My Wallet")}
                        </a>
                      </button>
                    </Link>
                    <button
                      className="dropdown-item"
                      type="button"
                      onClick={() => {
                        dispatch(LogoutAction());
                      }}
                    >
                      <a>
                        <i className="fa fa-sign-out"></i> {t("Logout")}
                      </a>
                    </button>
                  </div>
                </div>
              </li>

              <li className="hm-notify" id="notification_item" style={{ margin: '0 10px' }}>
                <div className="btn-group dropdown">
                  <button
                    type="button"
                    className="notification-btn dropdown-toggle"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span
                      className="notify-value hm-notify-number"
                      onClick={() => { }}
                    >
                      {notificationData?.length > 100
                        ? "99+"
                        : notificationData?.length}
                    </span>
                    <img src="/notification.png" className="img-fluid" alt="" />
                  </button>
                  <div className="dropdown-menu notification-list dropdown-menu-right">
                    <div className="notify-menu">
                      <div className="notification-list-title">
                        <div className="notify-counter">
                          <div className="notify-pending">
                            <p>
                              <span>{notificationData.length}</span>
                              {t("pending notifications")}
                            </p>
                            <a
                              onClick={() => {
                                seen();
                              }}
                              className="clear-all"
                              href="#"
                            >
                              {t("Clear All")}
                            </a>
                          </div>

                          <div className="notifiy-clear">
                            <Link href="/user/notification">
                              <a className="view-all">{t("View All")}</a>
                            </Link>
                            <HiArrowNarrowRight />
                          </div>
                        </div>
                      </div>
                      <div>
                        <div className="notify-grid-item">
                          {notificationData?.length > 0 ? (
                            notificationData
                              ?.slice(0, 5)
                              ?.map((item: any, index: number) => (
                                <div className="notify-icon-title" key={index}>
                                  <RiNotificationBadgeLine
                                    size={20}
                                    className="notify-menu-icon"
                                  />
                                  <div>
                                    <h6>{item.title.substring(0, 40)}</h6>
                                    <p>
                                      {item.notification_body.substring(0, 50)}
                                    </p>
                                    <span>
                                      {moment(item.created_at).format(
                                        "DD MMM YYYY"
                                      )}
                                    </span>
                                  </div>
                                </div>
                              ))
                          ) : (
                            <p className="notFountNotifyText">
                              {t("No Notification Found!")}
                            </p>
                          )}
                        </div>
                      </div>
                    </div>

                    <div
                      className="scroll-wrapper scrollbar-inner"
                      style={{
                        position: "relative",
                      }}
                    >
                      <ul
                        className="scrollbar-inner scroll-content"
                        style={{
                          height: "auto",
                          marginBottom: "0px",
                          marginRight: "0px",
                          maxHeight: "0px",
                        }}
                      ></ul>
                      <div className="scroll-element scroll-x">
                        <div className="scroll-element_outer">
                          <div className="scroll-element_size"></div>
                          <div className="scroll-element_track"></div>
                          <div className="scroll-bar"></div>
                        </div>
                      </div>
                      <div className="scroll-element scroll-y">
                        <div className="scroll-element_outer">
                          <div className="scroll-element_size"></div>
                          <div className="scroll-element_track"></div>
                          <div className="scroll-bar"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <nav className="main-menu">
                <ul>
                  <li className="hm-notify">
                    <a
                      className="arrow-icon"
                      href="#"
                      aria-expanded="true"
                      style={{ height: "48px" }}
                    >
                      <span className="">
                        <IoMdGlobe size={25} />
                      </span>
                      {/* <span className="cp-user-name">
                        {router.locale?.toLocaleUpperCase()}
                      </span> */}
                    </a>
                    <ul
                      className="dropdown-menu-main"
                      style={{ right: "0", left: "auto" }}
                    >
                      {settings?.LanguageList?.map((item: any, index: any) => (
                        <li key={index}>
                          <Link href={router.asPath} locale={item.key}>
                            <a className="py-1 menu-hover">{item.name}</a>
                          </Link>
                        </li>
                      ))}
                    </ul>
                  </li>
                  <li
                    onClick={() => {
                      darkModeToggle(settings, setTheme, dispatch);
                    }}
                  >
                    <a href="#">
                      {theme === 0 ? (
                        <>
                          <BsFillSunFill size={25} className="mr-2" />
                        </>
                      ) : (
                        <>
                          <BsFillMoonFill size={20} className="mr-2" />
                        </>
                      )}
                    </a>
                  </li>
                </ul>
              </nav>
            </ul>
          </div>
          <div
            className="cp-user-sidebar-toggler-s2"
            onClick={() => {
              setActive(true);
            }}
          >
            <img src="/menu.svg" className="img-fluid" alt="" />
          </div>
        </div>
      ) : (
        ""
      )}
    </div>
  );
};

export default NotificationDropdown;
