import request from "lib/request";

export const getGiftCardsData = async (ctxCookie: string) => {
  const { data } = await request.get("/gift-card/gift-card-main-page",{
    headers: {
      Authorization: `Bearer ${ctxCookie}`,
    },
  });
  return data;
};
