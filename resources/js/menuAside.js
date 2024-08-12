import {
  mdiAccountCircle,
  mdiViewDashboard,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  
  mdiResponsive,
  mdiPalette,
  mdiHospitalBuilding,
  mdiSquareCircle,
  mdiAlphaRBox,
  mdiInformation,
  mdiWallet,
  mdiCashFast,
  mdiAccountCash,
  mdiWalletOutline,
  mdiAccountCashOutline,
  mdiCellphoneWireless,
  mdiCellphoneDock,
  mdiTelevisionClassic,
  mdiLightningBoltOutline,
  mdiRouterWireless,
  mdiSchoolOutline,
} from "@mdi/js";


export default [
  {
    route: "dashboard",
    icon: mdiViewDashboard,
    label: "Dashboard",
  },
  {
    label: "Profile",
    icon: mdiAccountCircle,
    menu: [
      {
        route: "edit_profile",
        label: "Edit Profile",
      },
      {
        route: "change_password",
        label: "Change Password",
      },
    ],
  },
  
  // {
  //   label: "Genealogy",
  //   icon: mdiSquareCircle,
  //   menu: [
  //     {
  //       route: "genealogy_tree",
  //       label: "Genealogy Tree",
  //     },
  //     {
  //       route: "sponsor_tree",
  //       label: "Sponsor Tree",
  //     },
  //   ],
  // },
  // {
  //   route: "referral_link",
  //   label: "Referral Link",
  //   icon: mdiAlphaRBox,
  // },
  // {
  //   route: "earnings_wallet_page",
  //   label: "Earnings Wallet",
  //   icon: mdiAccountCashOutline,
  // },
  // {
  //   route: "earning_to_wallet_hist",
  //   label: "Earning To Wallet Hist.",
  //   icon: mdiCashFast,
  // },

  {
    route: "airtime_topup",
    icon: mdiCellphoneWireless,
    label: "Airtime Topup",
  },
  {
    route: "internet_data",
    icon: mdiCellphoneDock ,
    label: "Internet Data",
  },
  {
    route: "cable_tv",
    icon: mdiTelevisionClassic ,
    label: "Cable TV",
  },

  {
    route: "airtime_to_wallet",
    icon: mdiTelevisionClassic,
    label: "Airtime To Wallet",
  },
  {
    route: "electricity_topup",
    icon: mdiLightningBoltOutline,
    label: "Electricity Topup",
  },
  {
    route: "router_recharge",
    icon: mdiRouterWireless,
    label: "Router Recharge",
  },
  {
    route: "educational_vouchers",
    icon: mdiSchoolOutline,
    label: "Educational Vouchers",
  },
  // {
  //   label: "Services",
  //   icon: mdiInformation,
  //   menu: [
  //     {
  //       route: "airtime_topup",
  //       label: "Airtime Topup",
  //     },
  //     {
  //       route: "internet_data",
  //       label: "Internet Data",
  //     },
  //     {
  //       route: "cable_tv",
  //       label: "Cable TV",
  //     },
  //     {
  //       route: "electricity_topup",
  //       label: "Electricity Topup",
  //     },
  //     // {
  //     //   route: "airtime_to_wallet",
  //     //   label: "Airtime To Wallet",
  //     // },
  //     {
  //       route: "router_recharge",
  //       label: "Router Recharge",
  //     },
  //     {
  //       route: "educational_vouchers",
  //       label: "Educational Vouchers",
  //     },
      
  //   ],
  // },
  // {
  //   route: "goeasy_savings_main_page",
  //   label: "Go-Easy Savings",
  //   icon: mdiWalletOutline,
  // },
  // {
  //   label: "Easy Loan",
  //   icon: mdiAccountCash,
  //   menu: [
  //     {
  //       route: "apply_for_easy_loan_page",
  //       label: "Apply For Loan",
  //     },
  //     {
  //       route: "easy_loan_history_page",
  //       label: "View History",
  //     },
  //   ]
  // },
  {
    label: "E-Wallet",
    icon: mdiWallet,
    menu: [
      {
        route: "wallet.overview",
        label: "Overview",
      },
      // {
      //   route: "wallet.credit",
      //   label: "Credit Wallet",
      // },
      {
        route: "wallet.credit_history",
        label: "Wallet Credit History",
      },
      {
        route: "wallet.transfer",
        label: "Funds Transfer",
      },
      {
        route: "wallet.transfer_history",
        label: "Transfer History",
      },
      // {
      //   route: "wallet.withdrawal",
      //   label: "Funds Withdrawal",
      // },
      // {
      //   route: "wallet.withdrawal_history",
      //   label: "Withdrawal History",
      // },
      {
        route: "wallet.statement",
        label: "E-Wallet Statement",
      },

    ],
  },
  // {
  //   route: "tables",
  //   label: "Tables",
  //   icon: mdiTable,
  // },
  // {
  //   route: "forms",
  //   label: "Forms",
  //   icon: mdiSquareEditOutline,
  // },
  // {
  //   route: "ui",
  //   label: "UI",
  //   icon: mdiTelevisionClassicGuide,
  // },
  // {
  //   route: "responsive",
  //   label: "Responsive",
  //   icon: mdiResponsive,
  // },
  // {
  //   to: "/",
  //   label: "Styles",
  //   icon: mdiPalette,
  // },
  // {
  //   route: "profile",
  //   label: "Profile",
  //   icon: mdiAccountCircle,
  // },
  // {
  //   route: "sign_in",
  //   label: "Login",
  //   icon: mdiLock,
  // },
  // {
  //   route: "error",
  //   label: "Error",
  //   icon: mdiAlertCircle,
  // },
  // {
  //   label: "Dropdown",
  //   icon: mdiViewList,
  //   menu: [
  //     {
  //       label: "Item One",
  //     },
  //     {
  //       label: "Item Two",
  //     },
  //   ],
  // },
  // {
  //   href: "https://github.com/justboil/admin-one-vue-tailwind",
  //   label: "GitHub",
  //   icon: mdiGithub,
  //   target: "_blank",
  // },
];
