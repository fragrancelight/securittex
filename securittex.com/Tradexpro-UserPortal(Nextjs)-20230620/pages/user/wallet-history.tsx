import type { GetServerSideProps, NextPage } from "next";
import React, { useState } from "react";
import ReportSidebar from "layout/report-sidebar";
import DataTable from "react-data-table-component";
import {
  WithdrawAndDepositHistoryAction,
  handleSearch,
} from "state/actions/reports";
import { SSRAuthCheck } from "middlewares/ssr-authentication-check";
import { useRouter } from "next/router";
import useTranslation from "next-translate/useTranslation";
import moment from "moment";
import Footer from "components/common/footer";
import { toast } from "react-toastify";
import { BiCopy } from "react-icons/bi";
import SectionLoading from "components/common/SectionLoading";
import CustomDataTable from "components/Datatable";
const DepositHistory: NextPage = () => {
  const router = useRouter();
  const { type } = router.query;
  const { t } = useTranslation("common");
  const [search, setSearch] = useState<any>("");
  const [processing, setProcessing] = useState<boolean>(false);
  const [history, setHistory] = useState<any>([]);
  const [stillHistory, setStillHistory] = useState<any>([]);
  const LinkTopaginationString = (page: any) => {
    const url = page.url.split("?")[1];
    const number = url.split("=")[1];
    WithdrawAndDepositHistoryAction(
      type === "withdrawal" ? "withdraw" : "deposit",
      10,
      parseInt(number),
      setHistory,
      setProcessing,
      setStillHistory
    );
  };
  const getReport = async () => {
    if (type === "deposit" || type === "withdrawal") {
      WithdrawAndDepositHistoryAction(
        type === "withdrawal" ? "withdraw" : "deposit",
        10,
        1,
        setHistory,
        setProcessing,
        setStillHistory
      );
    }
  };
  const columns = [
    {
      Header: t("Created At"),
      accessor: "created_at",
    },
    {
      Header: t("Address"),
      accessor: "address",
    },
    {
      Header: t("Coin Type"),
      accessor: "coin_type",
    },
    {
      Header: t("Amount"),
      accessor: "amount",
    },
    {
      Header: t("Fees"),
      accessor: "fees",
    },
    {
      Header:
        type === t("deposit") ? t("Transaction Id") : t("Transaction Hash"),
      accessor: "transaction_id",
    },
    {
      Header: t("Status"),
      accessor: "status",
    },
  ];
  React.useEffect(() => {
    getReport();
    return () => {
      setHistory([]);
    };
  }, [type]);
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
                    {type === "deposit"
                      ? t("Deposit History")
                      : t("Withdrawal History")}
                  </h2>
                </div>
              </div>
            </div>

            <div className="asset-balances-area">
              {processing ? (
                <SectionLoading />
              ) : (
                <div className="asset-balances-left">
                  <div className="section-wrapper">
                    <div className="tableScroll">
                      <div className="cp-user-wallet-table table-responsive tableScroll">
                        <CustomDataTable columns={columns} data={history} />
                      </div>
                      {history?.length > 0 && (
                        <div
                          className="pagination-wrapper"
                          id="assetBalances_paginate"
                        >
                          <span>
                            {stillHistory?.histories?.links.map(
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
  await SSRAuthCheck(ctx, "/user/wallet-history");
  return {
    props: {},
  };
};

export default DepositHistory;
