import ImageComponent from "components/common/ImageComponent";
import request from "lib/request";
import useTranslation from "next-translate/useTranslation";
import React from "react";
import { BsGiftFill } from "react-icons/bs";
import { toast } from "react-toastify";

export default function MyCardModal({
  setIsModalOpen,
  giftCardData,
  sendCryptoCardModalHandler,
}: any) {
  const { t } = useTranslation();
  const changeStatusGiftCard = async () => {
    let buyDetails: any = {
      coin_type: giftCardData?.coin_type,
      wallet_type: 1,
      uid: giftCardData.uid,
      status: giftCardData?.lock_status,
      amount: giftCardData?.amount,
      banner_id: giftCardData?.gift_card_banner_id,
      lock: giftCardData._lock == 1 ? 0 : 1,
      bulk: 0,
    };
    const { data } = await request.post(`/gift-card/buy-card`, {
      ...buyDetails,
    });
    if (data.success) {
      toast.success(data.message);
      setIsModalOpen(false);
    } else {
      toast.error(data.message);
      setIsModalOpen(false);
    }
  };
  return (
    <div id="demo-modal" className="gift-card-modal">
      <div className="gift-card-modal__content p-5">
        <h2>Gift Card Details</h2>

        <div className="row my-5">
          <div className="col-lg-6 col-md-6 col-12">
            <div className="">
              <div className="relative">
                <ImageComponent
                  src={giftCardData?.banner?.image || "/demo_gift_banner.png"}
                  height={300}
                />{" "}
                <div>
                  <div className="d-flex gap-10 buy-absolute-btn">
                    <BsGiftFill size={22} />
                    <h4>{`${parseFloat(giftCardData?.amount)} ${
                      giftCardData?.coin_type
                    }`}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="col-lg-6 col-md-6 col-12">
            <h3 className="mb-3">{t(giftCardData?.banner?.title)}</h3>
            <h5 className="font-normal">
              {t(giftCardData?.banner?.sub_title)}
            </h5>
            <div className="mt-3">
              <p>
                <strong>Coin Type: </strong> {t(giftCardData?.coin_type)}
              </p>
              <p>
                <strong>Category: </strong>{" "}
                {t(giftCardData?.banner?.category?.name)}
              </p>
              {giftCardData?.lock && (
                <p>
                  <strong>Lock: </strong> {t(giftCardData?.lock)}
                </p>
              )}

              {giftCardData?.wallet_type && (
                <p>
                  <strong>Wallet Type: </strong> {t(giftCardData?.wallet_type)}
                </p>
              )}

              <p>
                <strong>Status: </strong> {t(giftCardData?.status ?? "Active")}
              </p>
            </div>
          </div>
        </div>

        <div className="text-right">
          {Number(giftCardData.lock_status) === 1 && (
            <button
              type="button"
              className="btn bg-primary-color capitalize mr-4"
              onClick={changeStatusGiftCard}
            >
              {Number(giftCardData._lock) === 0 ? t("Locked") : t("Unlocked")}
            </button>
          )}
          {giftCardData._status == 1 && (
            <button
              type="button"
              className="btn bg-primary-color capitalize"
              onClick={sendCryptoCardModalHandler}
            >
              {t("Send crypto gift card")}
            </button>
          )}
        </div>

        <span
          className="gift-card-modal__close text-45 pointer"
          onClick={() => setIsModalOpen(false)}
        >
          &times;
        </span>
      </div>
    </div>
  );
}
