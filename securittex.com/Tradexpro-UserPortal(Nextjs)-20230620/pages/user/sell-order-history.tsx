import type { GetServerSideProps, NextPage } from "next";
import ReportSidebar from "layout/report-sidebar";
import React, { useState } from "react";
import { SSRAuthCheck } from "middlewares/ssr-authentication-check";
import DataTable from "react-data-table-component";
import {
  AllSellOrdersHistoryAction,
  handleSearchItems,
} from "state/actions/reports";
import TableLoading from "components/common/SectionLoading";
import useTranslation from "next-translate/useTranslation";
import moment from "moment";
import { formatCurrency } from "common";
import { customPage, landingPage } from "service/landing-page";
import Footer from "components/common/footer";
const SellOrderHistory: NextPage = () => {
  type searchType = string;
  const [search, setSearch] = useState<searchType>("");
  const [sortingInfo, setSortingInfo] = useState<any>({
    column_name: "created_at",
    order_by: "desc",
  });
  const { t } = useTranslation("common");
  const [processing, setProcessing] = useState<boolean>(false);
  const [history, setHistory] = useState<any>([]);
  const [stillHistory, setStillHistory] = useState<any>([]);
  const LinkTopaginationString = (page: any) => {
    const url = page.url.split("?")[1];
    const number = url.split("=")[1];
    AllSellOrdersHistoryAction(
      10,
      parseInt(number),
      setHistory,
      setProcessing,
      setStillHistory,
      sortingInfo.column_name,
      sortingInfo.order_by
    );
  };
  const getReport = async () => {
    AllSellOrdersHistoryAction(
      10,
      1,
      setHistory,
      setProcessing,
      setStillHistory,
      sortingInfo.column_name,
      sortingInfo.order_by
    );
  };

  const columns = [
    {
      name: t("Base Coin"),
      selector: (row: any) => row?.base_coin,
      sortable: true,
    },
    {
      name: t("Trade Coin"),
      selector: (row: any) => row?.trade_coin,
      sortable: true,
    },
    {
      name: t("Amount"),
      selector: (row: any) => row?.amount,
      sortable: true,
      cell: (row: any) => (
        <div className="blance-text">
          <span className="blance market incree">
            {parseFloat(row?.amount).toFixed(8)}
          </span>
        </div>
      ),
    },
    {
      name: t("Processed"),
      selector: (row: any) => row?.processed,
      sortable: true,
      cell: (row: any) => (
        <div className="blance-text">
          <span className="blance market incree">
            {parseFloat(row?.processed).toFixed(8)}
          </span>
        </div>
      ),
    },
    {
      name: t("Price"),
      selector: (row: any) => row?.price,
      sortable: true,
      cell: (row: any) => (
        <div className="blance-text">
          <span className="blance market incree">
            {formatCurrency(row?.price)}
          </span>
        </div>
      ),
    },
    {
      name: t("Status"),
      selector: (row: any) => row?.status,
      sortable: true,
      cell: (row: any) => (
        <div>
          {row.status === 0 ? (
            <span className="text-warning">{t("Pending")}</span>
          ) : row.status === 1 ? (
            <span className="text-success"> {t("Success")}</span>
          ) : (
            <span className="text-danger">{t("Failed")}</span>
          )}
        </div>
      ),
    },
    {
      name: t("Date"),
      selector: (row: any) =>
        moment(row.created_at).format("YYYY-MM-DD HH:mm:ss"),
      sortable: true,
    },
  ];
  React.useEffect(() => {
    getReport();
    return () => {
      setHistory([]);
    };
  }, []);
  return (
    <>
      <div className="page-wrap rightMargin">
        <ReportSidebar />

        <div className="page-main-content">
          <div className="container-fluid">
            <div className="section-top-wrap mb-25">
              <div className="overview-area">
                <div className="overview-left">
                  <h2 className="section-top-title">
                    {t("Sell Order History")}
                  </h2>
                </div>
              </div>
            </div>

            <div className="asset-balances-area">
              {processing ? (
                <TableLoading />
              ) : (
                <div className="asset-balances-left">
                  <div className="section-wrapper">
                    <div className="tableScroll">
                      <div
                        id="assetBalances_wrapper"
                        className="dataTables_wrapper no-footer"
                      >
                        <div className="dataTables_head">
                          <div
                            className="dataTables_length"
                            id="assetBalances_length"
                          >
                            <label className="">
                              {t("Show")}
                              <select
                                name="assetBalances_length"
                                aria-controls="assetBalances"
                                className=""
                                onChange={(e) => {
                                  AllSellOrdersHistoryAction(
                                    parseInt(e.target.value),
                                    1,
                                    setHistory,
                                    setProcessing,
                                    setStillHistory,
                                    sortingInfo.column_name,
                                    sortingInfo.order_by
                                  );
                                }}
                              >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                              </select>
                            </label>
                          </div>
                          <div id="table_filter" className="dataTables_filter">
                            <label>
                              {t("Search")}:
                              <input
                                type="search"
                                className="data_table_input"
                                placeholder=""
                                aria-controls="table"
                                value={search}
                                onChange={(e) => {
                                  handleSearchItems(
                                    e,
                                    setSearch,
                                    stillHistory,
                                    setHistory
                                  );
                                }}
                              />
                            </label>
                          </div>
                        </div>
                      </div>

                      <DataTable columns={columns} data={history} />
                      {history?.length > 0 && (
                        <div
                          className="pagination-wrapper"
                          id="assetBalances_paginate"
                        >
                          <span>
                            {stillHistory?.items?.links.map(
                              (link: any, index: number) =>
                                link.label === "&laquo; Previous" ? (
                                  <a
                                    className="paginate-button"
                                    onClick={() => {
                                      if (link.url)
                                        LinkTopaginationString(link);
                                    }}
                                    key={index}
                                  >
                                    <i className="fa fa-angle-left"></i>
                                  </a>
                                ) : link.label === "Next &raquo;" ? (
                                  <a
                                    className="paginate-button"
                                    onClick={() => LinkTopaginationString(link)}
                                    key={index}
                                  >
                                    <i className="fa fa-angle-right"></i>
                                  </a>
                                ) : (
                                  <a
                                    className={`paginate_button paginate-number ${
                                      link.active === true && "text-warning"
                                    }`}
                                    aria-controls="assetBalances"
                                    data-dt-idx="1"
                                    onClick={() => LinkTopaginationString(link)}
                                    key={index}
                                  >
                                    {link.label}
                                  </a>
                                )
                            )}
                          </span>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </>
  );
};
export const getServerSideProps: GetServerSideProps = async (ctx: any) => {
  await SSRAuthCheck(ctx, "/user/sell-order-history");
  return {
    props: {},
  };
};

export default SellOrderHistory;
