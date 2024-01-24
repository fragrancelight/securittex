import useTranslation from "next-translate/useTranslation";
import React, { useMemo } from "react";
import { useTable, useSortBy, useGlobalFilter } from "react-table";

const CustomDataTable = ({
  columns,
  data,
  Links,
  paginateFunction,
  paginate = true,
}: any) => {
  const dataColumns = useMemo(() => columns, [columns]);
  const tableData = useMemo(() => data, [data]);
  const {
    getTableProps,
    getTableBodyProps,
    headerGroups,
    rows,
    prepareRow,
    state,
    //@ts-ignore
    setGlobalFilter,
  } = useTable(
    {
      columns: dataColumns,
      data: tableData,
    },
    useGlobalFilter,
    useSortBy
  );
  const { t } = useTranslation("common");

  const { globalFilter }: any = state;

  return (
    <div>
      <div id="assetBalances_wrapper" className="dataTables_wrapper no-footer">
        <div className="dataTables_head">
          <div className="dataTables_length" id="assetBalances_length">
            <label className="">
              {t("Show")}
              <select
                name="assetBalances_length"
                aria-controls="assetBalances"
                className=""
                placeholder="10"
                onChange={(e) => {}}
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
              {"Search"}
              <input
                type="search"
                className="data_table_input"
                aria-controls="table"
                placeholder="Search..."
                value={globalFilter || ""}
                onChange={(e) => setGlobalFilter(e.target.value)}
              />
            </label>
          </div>
        </div>
      </div>
      <table {...getTableProps()} className="table table-striped">
        <thead>
          {headerGroups.map((headerGroup, index) => (
            <tr {...headerGroup.getHeaderGroupProps()} key={index}>
              {headerGroup.headers.map((column: any, key: number) => (
                <th
                  key={key}
                  {...column.getHeaderProps(column.getSortByToggleProps())} // Add sorting props to the column header
                  style={{
                    borderBottom: "1px solid #7d7d7d33",
                    background: "var(--background-color)",
                    padding: "8px",
                    textAlign: "left", // Update this line
                    cursor: "pointer",
                  }}
                >
                  {column.render("Header")}
                  <span>
                    {column.isSorted ? (
                      column.isSortedDesc ? (
                        <i className="fa fa-caret-down" />
                      ) : (
                        <i className="fa fa-caret-up" />
                      )
                    ) : (
                      ""
                    )}
                  </span>
                </th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody {...getTableBodyProps()}>
          {rows.map((row, index) => {
            prepareRow(row);
            return (
              <tr {...row.getRowProps()} key={index}>
                {row.cells.map((cell, key) => (
                  <td
                    //@ts-ignore
                    key={key}
                    {...cell.getCellProps()}
                    style={{
                      borderBottom: "1px solid #7d7d7d33",
                      padding: "8px",
                      textAlign: "start",
                      whiteSpace: "nowrap",
                      overflow: "hidden",
                      textOverflow: "ellipsis",
                      maxWidth: "20px",
                    }}
                  >
                    {cell.render("Cell")}
                  </td>
                ))}
              </tr>
            );
          })}
        </tbody>
      </table>
      {paginate === true && (
        <div className="pagination-wrapper" id="assetBalances_paginate">
          <span>
            {Links?.map((link: any, index: number) =>
              link.label === "&laquo; Previous" ? (
                <a
                  className="paginate-button"
                  onClick={() => {
                    if (link.url) paginateFunction(link);
                  }}
                  key={index}
                >
                  <i className="fa fa-angle-left"></i>
                </a>
              ) : link.label === "Next &raquo;" ? (
                <a
                  className="paginate-button"
                  onClick={() => paginateFunction(link)}
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
                  onClick={() => paginateFunction(link)}
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
  );
};

export default CustomDataTable;
