import ImageComponent from "components/common/ImageComponent";
import useTranslation from "next-translate/useTranslation";
import Link from "next/link";
import React, { useState } from "react";
import { BsArrowRight } from "react-icons/bs";
import MyCardModal from "../modal/MyCardModal";
import SendCryptoCardModal from "../modal/SendCryptoCardModal";
import { NoItemFound } from "components/NoItemFound/NoItemFound";

export default function MyCards({ myCards }: any) {
  const { t } = useTranslation();
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isSendCryptoCardModalOpen, setIsSendCryptoCardModalOpen] =
    useState(false);
  const [giftCardData, setGiftCardData] = useState({});
  const myCardHandle = (cardData: any) => {
    setGiftCardData(cardData);
    setIsModalOpen(true);
  };

  const sendCryptoCardModalHandler = () => {
    setIsSendCryptoCardModalOpen(true);
    setIsModalOpen(false);
  };
  return (
    <div className="container pb-80">
      <div className="d-flex justify-content-between">
        <div>
          <h3>My Cards</h3>
        </div>
        <div>
          <Link href={`/gift-cards/my-cards`}>
            <a>
              <div className="d-flex align-items-center">
                <span className="inline-block pr-2">All({myCards.length})</span>
                <span className="gift-card-arrow">
                  <BsArrowRight />
                </span>
              </div>
            </a>
          </Link>
        </div>
      </div>
      {myCards.length > 0 ? (
        <div className="row mt-3 get-touch-area">
          {myCards.map((item: any, index: number) => (
            <div className="col-lg-4 my-3 pointer" key={index}>
              <div
                className="single-card h-full"
                onClick={() => myCardHandle(item)}
              >
                <ImageComponent
                  src={item.banner.image || "/demo_gift_banner.png"}
                  height={300}
                />
                <div className="mt-4">
                  <h4>{t(item.banner.title)}</h4>
                  <p>{t(item.banner.sub_title)}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      ) : (
        <div className="mt-4">
          <NoItemFound />
        </div>
      )}
      {isModalOpen && (
        <MyCardModal
          giftCardData={giftCardData}
          setIsModalOpen={setIsModalOpen}
          sendCryptoCardModalHandler={sendCryptoCardModalHandler}
        />
      )}
      {isSendCryptoCardModalOpen && (
        <SendCryptoCardModal
          setIsSendCryptoCardModalOpen={setIsSendCryptoCardModalOpen}
          giftCardData={giftCardData}
        />
      )}
    </div>
  );
}
