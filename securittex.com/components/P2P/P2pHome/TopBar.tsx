import { RiPagesLine } from "react-icons/ri";
import { HiOutlineHome, HiUsers } from "react-icons/hi";
import Link from "next/link";
import { AiOutlineWallet } from "react-icons/ai";
import { GrHomeRounded } from "react-icons/gr";
export const P2pTopBar = () => {
  return (
    <div className="py-3">
      <div className="container">
        <div className="row">
          <div className="col-12">
            <ul className="d-flex justify-content-between topBarList">
              <div className="d-flex " style={{gap:'28px'}}>
                <li>
                  <Link href="/p2p">
                    <a>
                      <HiOutlineHome />
                      Home
                    </a>
                  </Link>
                </li>
                <li>
                  <Link href="/p2p/my-order">
                    <a>
                      <RiPagesLine />
                      Orders
                    </a>
                  </Link>
                </li>
                <li>
                  <Link href="/p2p/p2p-profile">
                    <a>
                      <HiUsers />
                      P2P User Center
                    </a>
                  </Link>
                </li>
                <li>
                  <Link href="/p2p/p2p-wallet">
                    <a>
                      <AiOutlineWallet />
                      P2P Wallet
                    </a>
                  </Link>
                </li>
              </div>
              <li style={{position:'relative'}}>
                <a
                  href=""
                  className="dropdown-toggle"
                  data-toggle="dropdown"
                  aria-expanded="false"
                >
                  More
                </a>
                <div className="dropdown-menu secendary-dropdown-bg">
                  <Link href="/p2p/add-post">
                    <a className="dropdown-item menu-hover">Ad Create</a>
                  </Link>
                  <Link href="/p2p/my-buy-ads">
                    <a className="dropdown-item menu-hover">My Buy Ads</a>
                  </Link>
                  <Link href="/p2p/my-sell-ads">
                    <a className="dropdown-item menu-hover">My Sell Ads</a>
                  </Link>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  );
};
