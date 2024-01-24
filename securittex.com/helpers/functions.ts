import { setThemeColor } from "state/reducer/common";

export const checkDarkMode = (settings: any, dispatch: any) => {
  const theme = localStorage.getItem("theme");
  if (theme === "light") {
    localStorage.setItem("theme", "light");
    dispatch(setThemeColor("light"));
    document.documentElement.setAttribute("data-theme", "light");
    settings.theme_color.map((themeColors: any) => {
      if (!themeColors.value) {
        return;
      }
      document.documentElement.style.setProperty(
        themeColors.name,
        themeColors.value
      );
    });
  } else {
    localStorage.setItem("theme", "dark");
    dispatch(setThemeColor("dark"));
    document.documentElement.setAttribute("data-theme", "dark");
    settings.dark_theme_color.map((themeColors: any) => {
      if (!themeColors.value) {
        return;
      }
      document.documentElement.style.setProperty(
        themeColors.name,
        themeColors.value
      );
    });
  }
};
export const checkDarkModeWithoutSettings = () => {
  const theme = localStorage.getItem("theme");
  if (theme === "light") {
    localStorage.setItem("theme", "light");
    // dispatch(setTheme("light"));

    document.documentElement.setAttribute("data-theme", "dark");
  } else {
    localStorage.setItem("theme", "dark");
    // dispatch(setTheme("dark"));
    document.documentElement.setAttribute("data-theme", "dark");
  }
};
export const darkModeToggle = (settings: any, setTheme: any, dispatch: any) => {
  const theme = localStorage.getItem("theme");
  if (theme === "dark") {
    setTheme(1);
    dispatch(setThemeColor("light"));
    document.documentElement.setAttribute("data-theme", "light");
    localStorage.setItem("theme", "light");
    settings.theme_color.map((theme_color: any) => {
      if (!theme_color.value) {
        return;
      }
      document.documentElement.style.setProperty(
        theme_color.name,
        theme_color.value
      );
    });
  } else {
    setTheme(0);
    dispatch(setThemeColor("dark"));

    document.documentElement.setAttribute("data-theme", "dark");
    settings.dark_theme_color.map((theme_color: any) => {
      if (!theme_color.value) {
        return;
      }
      document.documentElement.style.setProperty(
        theme_color.name,
        theme_color.value
      );
    });
    localStorage.setItem("theme", "dark");
  }
};

export const darkModeToggleDashboard = (dispatch:any) => {
  const theme = localStorage.getItem("theme");
  if (theme === "dark") {
    document.documentElement.setAttribute("data-theme", "light");
    dispatch(setThemeColor("light"));
    localStorage.setItem("theme", "light");
  } else {
    dispatch(setThemeColor("dark"));
    document.documentElement.setAttribute("data-theme", "dark");
    localStorage.setItem("theme", "dark");
  }
};
export const checkThemeState = (setTheme: any, dispatch:any) => {
  const theme = localStorage.getItem("theme");
  if (theme === "light") {
    setTheme(1);
    // dispatch(setTheme("light"));
  } else {
    setTheme(0);
    // dispatch(setTheme("light"));
  }
};
export const rootThemeCheck = () => {
  const theme = localStorage.getItem("theme");
  if (theme === "light") {
    localStorage.setItem("theme", "light");
    document.documentElement.setAttribute("data-theme", "light");
  } else {
    localStorage.setItem("theme", "dark");
    document.documentElement.setAttribute("data-theme", "dark");
  }
};
