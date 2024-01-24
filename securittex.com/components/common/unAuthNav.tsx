import React, { useEffect, useState } from "react";
import Link from "next/link";
import { useDispatch, useSelector } from "react-redux";
import { BsFillMoonFill, BsFillSunFill, BsBarChartLine } from "react-icons/bs";
import { FaPeopleArrows } from "react-icons/fa";
import { BiShapeCircle } from "react-icons/bi";
import OutsideClickHandler from "react-outside-click-handler";
import { RootState } from "state/store";
import useTranslation from "next-translate/useTranslation";
import { notification } from "service/notification";
import { useRouter } from "next/router";
import { checkThemeState, darkModeToggle } from "helpers/functions";
import { IoMdGlobe } from "react-icons/io";



const UnAuthNav = () => {
  const { isLoggedIn, user, logo } = useSelector(
    (state: RootState) => state.user
  );
  const router = useRouter();
  const [theme, setTheme] = useState(0);
  const { settings } = useSelector((state: RootState) => state.common);

  const [active, setActive] = useState(false);
  const [notificationData, setNotification] = useState<any>([]);
  const { t } = useTranslation("common");
  const getNotifications = async () => {
    const data = await notification();
    setNotification(data.data.data);
  };
  const dispatch=useDispatch()

  useEffect(() => {
    checkThemeState(setTheme,dispatch);
    isLoggedIn && getNotifications();
  }, [isLoggedIn]);
  useEffect(() => {
    if (router.locale === "ar") {
      document.body.classList.add("rtl-style");
    } else {
      document.body.classList.remove("rtl-style");
    }
  }, [router.locale]);
  return (
    <div className="">
      <div className="cp-user-top-bar position-fixed">
        <div className="container-fluid">
          <div className="d-flex align-items-center justify-content-between">
            <div className="d-flex align-items-center" style={{ gap: "20px" }}>
              <div className="cp-user-logo">
                <Link href="/">
                  <a href="">
                    <img
                      src={logo || ""}
                      className="img-fluid cp-user-logo-large"
                      alt=""
                    />
                  </a>
                </Link>
              </div>
              <div className="main-menu">
                <ul>
                  <li>
                    <a
                      className="flex"
                      href="#"
                      aria-expanded="true"
                      style={{ height: "48px" }}
                    >
                      <span className="cp-user-icon">
                        <BsBarChartLine />
                      </span>
                      <span>{t("Exchange")}</span>
                    </a>

                    <ul className="lang-list dropdown-menu-main">
                      <li>
                        <Link href="/exchange/dashboard">
                          <a className="py-1 menu-hover">
                            <span className="cp-user-icon">
                              {" "}
                              <BiShapeCircle />{" "}
                            </span>{" "}
                            <span>{t("Spot Trading")}</span>{" "}
                          </a>
                        </Link>
                      </li>
                      {parseInt(settings?.p2p_module) === 1 && (
                        <li>
                          <Link href="/p2p">
                            <a className="py-1 menu-hover">
                              {" "}
                              <span className="cp-user-icon">
                                <FaPeopleArrows />
                              </span>
                              <span>{t("P2P Trading")}</span>{" "}
                            </a>
                          </Link>
                        </li>
                      )}
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <div className="d-none d-lg-flex align-items-center">
              <nav className="main-menu">
                <ul>
                  <li>
                    <Link href="/signin">{t("Login")}</Link>
                  </li>
                  <li>
                    <Link href="/signup">
                      <a
                        style={{
                          padding: "3px 10px",
                          background: "#fdd636",
                          borderRadius: "5px",
                          gap: "4px",
                        }}
                      >
                        <svg
                          style={{ width: "16px", height: "16px" }}
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 24 24"
                          fill="none"
                          className="text-dark"
                        >
                          <path
                            d="M13.5 6.379V3h-3v3.379l-2.94-2.94-2.12 2.122L7.878 8H4v3h6.75V8h2.5v3H20V8h-3.879l2.44-2.44-2.122-2.12L13.5 6.378zM4 13.5V20h6.75v-6.5H4zM13.25 20H20v-6.5h-6.75V20z"
                            fill="currentColor"
                          ></path>
                        </svg>
                        <span className="text-dark">{t("Sign up")}</span>{" "}
                      </a>
                    </Link>
                  </li>

                  <li
                    style={{ height: "48px" }}
                    className="d-flex align-items-center"
                  >
                    <a className="flex" href="#" aria-expanded="true">
                      <IoMdGlobe size={20} />{" "}
                      <span className="ml-2">
                        {router.locale?.toLocaleUpperCase()}
                      </span>
                    </a>
                    <ul
                      className="lang-list dropdown-menu-main"
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
                      darkModeToggle(settings, setTheme,dispatch);
                    }}
                  >
                    <a href="#">
                      {theme === 0 ? (
                        <>
                          <BsFillSunFill size={20} className="mr-2" />
                        </>
                      ) : (
                        <>
                          <BsFillMoonFill size={14} className="mr-2" />
                        </>
                      )}
                    </a>
                  </li>
                </ul>
              </nav>
            </div>

            <div className="d-xl-none d-block">
              <div className="cp-user-top-bar-right">
                <div
                  className="cp-user-sidebar-toggler-s2"
                  onClick={() => {
                    setActive(active ? false : true);
                  }}
                >
                  <img src="/menu.svg" className="img-fluid" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <OutsideClickHandler onOutsideClick={() => setActive(false)}>
        <div className={`cp-user-sidebar ${active ? "active" : ""}`}>
          <div
            onClick={() => setActive(false)}
            className="cp-user-sidebar-menu scrollbar-inner"
          >
            <nav>
              <ul id="metismenu">
                <li>
                  <Link href="/exchange/dashboard">{t("Spot Trading")}</Link>
                </li>
                {parseInt(settings?.p2p_module) === 1 && (
                  <li>
                    <Link href="/p2p">{t("P2p Trading")}</Link>
                  </li>
                )}

                <li>
                  <Link href="/signin">{t("Login")}</Link>
                </li>
                <li>
                  <Link href="/signup">{t("Sign up")}</Link>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </OutsideClickHandler>
    </div>
  );
};

export default UnAuthNav;
