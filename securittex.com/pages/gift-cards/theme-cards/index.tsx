import { NoItemFound } from "components/NoItemFound/NoItemFound";
import { CUstomSelect } from "components/common/CUstomSelect";
import ImageComponent from "components/common/ImageComponent";
import SectionLoading from "components/common/SectionLoading";
import Footer from "components/common/footer";
import request from "lib/request";
import { SSRAuthCheck } from "middlewares/ssr-authentication-check";
import { GetServerSideProps } from "next";
import useTranslation from "next-translate/useTranslation";
import Link from "next/link";
import React, { useEffect, useState } from "react";
import ReactPaginate from "react-paginate";
import { toast } from "react-toastify";

const limit = 10;
export default function Index() {
  const { t } = useTranslation();
  const [themedCardData, setThemedCardData] = useState<any>({});
  const [activeCategory, setActiveCategory] = useState({
    value: "all",
    label: "All",
  });
  const [allGiftCards, setAllGiftCards] = useState<any>({});
  const [categories, setCategories] = useState([
    {
      value: "all",
      label: "All",
    },
  ]);

  const [loading, setLoading] = useState(true);
  const [productLoading, setProductLoading] = useState(false);
  useEffect(() => {
    getCategoryData();
    getThemedGiftCardData("all", 1, limit);
  }, []);

  const getCategoryData = async () => {
    setLoading(true);
    const { data } = await request.get(`/gift-card/gift-card-themes-page`);
    if (!data.success) {
      toast.error(data.message);
      setLoading(false);
      return;
    }
    setThemedCardData(data.data);
    setCategories((prev) => [...prev, ...data.data.categories]);
    setLoading(false);
  };

  const getThemedGiftCardData = async (
    category: any,
    page: any,
    limit: any
  ) => {
    setProductLoading(true);
    const { data } = await request.get(
      `/gift-card/get-gift-card-themes?uid=${category}&limit=${limit}&page=${page}`
    );
    if (!data.success) {
      toast.error(data.message);
      setProductLoading(false);
      return;
    }
    setAllGiftCards(data.data);
    setProductLoading(false);
  };

  const handleCategory = (event: any) => {
    getThemedGiftCardData(event.value, 1, limit);
    setActiveCategory(event);
  };

  const handlePageClick = (event: any) => {
    getThemedGiftCardData(activeCategory.value, event.selected + 1, limit);
  };

  if (loading) return <></>;
  return (
    <section>
      {/* gift card banner start */}
      <div className="bg-card-primary-color py-80">
        <div className="container">
          <div className="row">
            <div className="col-lg-6 d-flex align-items-center justify-content-center">
              <div>
                <h1 className="text-45 text-capitalize font-bold gift-font-color">
                  {t(themedCardData?.header || "Themed Gift Cards")}
                </h1>
                <p className="my-3 gift-font-color font-medium text-16">
                  {t(
                    themedCardData?.description ||
                      "Tradexpro exchange is such a marketplace where people can trade directly with each other"
                  )}
                </p>
              </div>
            </div>
            <div className="col-lg-6 grid">
              <ImageComponent
                src={themedCardData?.banner || "/demo_gift_banner.png"}
                height={300}
              />{" "}
            </div>
          </div>
        </div>
      </div>
      {/* gift card banner end */}

      {/* Themed Gift Cards start */}
      <div className="py-80">
        <div className="container">
          <div className="row">
            <div className="col-lg-9 col-md-9 col-6">
              <div>
                <h3>{t(`Themed Gift Cards`)}</h3>
                <small>{t(`Send a crypto gift card for any occasion`)}</small>
              </div>
            </div>

            <div className="col-lg-3 col-md-3 col-6">
              <div className="d-flex align-items-center gap-10 border px-2 rounded ">
                <span>
                  <b>{t(`Category:`)}</b>{" "}
                </span>
                <CUstomSelect
                  options={categories}
                  classname={"themed-category-select-section w-full"}
                  handleFunction={handleCategory}
                  defaultValue={categories[0]}
                />
              </div>
            </div>
          </div>
          {productLoading ? (
            <SectionLoading />
          ) : (
            <>
              {allGiftCards?.data?.length > 0 ? (
                <div className="row mt-3">
                  {allGiftCards?.data?.map((item: any, index: number) => (
                    <div className="col-lg-3 my-1" key={index}>
                      <Link href={`/gift-cards/buy/${item.uid}`}>
                        <a>
                          <ImageComponent
                            src={item.banner || "/demo_gift_banner.png"}
                            height={300}
                          />
                        </a>
                      </Link>
                    </div>
                  ))}
                </div>
              ) : (
                <div className="mt-4">
                  <NoItemFound />
                </div>
              )}
            </>
          )}

          <div className="row justify-content-center mt-5">
            <ReactPaginate
              nextLabel=">"
              onPageChange={handlePageClick}
              pageRangeDisplayed={5}
              pageCount={Math.ceil(allGiftCards.total / limit)}
              previousLabel="<"
              renderOnZeroPageCount={null}
              className={`d-flex align-items-center justify-content-center`}
              pageLinkClassName={`paginate-number`}
              activeLinkClassName={`active-paginate-cls`}
              previousLinkClassName={`text-primary-color text-25 mr-2`}
              nextLinkClassName={`text-primary-color text-25 ml-2`}
            />
          </div>
        </div>
      </div>
      {/* Themed Gift Cards end */}
      <Footer />
    </section>
  );
}
export const getServerSideProps: GetServerSideProps = async (ctx: any) => {
  await SSRAuthCheck(ctx, "/gift-cards");

  return {
    props: {},
  };
};
