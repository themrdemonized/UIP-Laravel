import VueRouter from 'vue-router'

// Pages
import ChooseHouse from '../components/ChooseFlat/ChooseHouse'
import ChooseFloor from "../components/ChooseFlat/ChoouseFloor";
import ChooseFlat from "../components/ChooseFlat/ChooseFlat";
import ChooseObject from "../components/ChooseFlat/ChooseObject";
import Flat from "../components/ChooseFlat/Flat";
import FlatList from "../components/ChooseFlat/FlatList";
import AdminApp from "../components/admin/AdminApp";
import UserApp from "../components/UserApp";
import AdminDashboard from "../components/admin/AdminDashboard";
import AdminObjects from "../components/admin/AdminObjects";
import AdminNews from "../components/admin/AdminNews";
import AdminUsers from "../components/admin/AdminUsers";
import AdminRequests from "../components/admin/AdminRequests";
import ObjectShow from "../components/admin/Objects/ObjectShow";
import ObjectEdit from "../components/admin/Objects/ObjectEdit";
import HouseCreate from "../components/admin/Houses/HouseCreate";
import HouseEdit from "../components/admin/Houses/HouseEdit";
import HouseShow from "../components/admin/Houses/HouseShow";
import AdminPrices from "../components/admin/AdminPrices";
import FloorEdit from "../components/admin/Floors/FloorEdit";
import FloorCreate from "../components/admin/Floors/FloorCreate";
import FloorShow from "../components/admin/Floors/FloorShow";
import About from "../components/About";
import Register from "../components/auth/Register";
import Login from "../components/auth/Login";
import FlatCreate from "../components/admin/Flats/FlatCreate";
import FlatEdit from "../components/admin/Flats/FlatEdit";
import Home from "../components/Home"
import AdminReserves from "../components/admin/AdminReserves";
import AdminNewCreate from "../components/admin/News/AdminNewCreate";
import AdminNewUpdate from "../components/admin/News/AdminNewUpdate";
import News from "../components/News";
import ShowNew from "../components/ShowNew";
import AdminFindFlat from "../components/admin/AdminFindFlat";
import AdminShowFlat from "../components/admin/AdminShowFlat";
import AdminUserShow from "../components/admin/Users/AdminUserShow";
import AdminOfficeShow from "../components/admin/AdminOfficeShow";
import OfficeUpdate from "../components/admin/Offices/OfficeUpdate";
import OfficeCreate from "../components/admin/Offices/OfficeCreate";
import PantryEdit from "../components/admin/Pantry/PantryEdit";
import PantryCreate from "../components/admin/Pantry/PantryCreate";
import AdminPantryShow from "../components/admin/AdminPantryShow";
import Contacts from "../components/Contacts";
import AdminDocuments from "../components/admin/AdminDocuments";
import DocUpdate from "../components/admin/Documents/DocUpdate";
import DocCreate from "../components/admin/Documents/DocCreate";
import AdminPhotoReport from "../components/admin/AdminPhotoReport";
import PhotoReportCreate from "../components/admin/PhotoReports/PhotoReportCreate";
import PhotoReportEdit from "../components/admin/PhotoReports/PhotoReportEdit";
import NotFound from "../components/layout/NotFound";
import Achievements from "../components/Achievements";
import Reserve from "../components/Reserve";
import ObjectCreate from "../components/admin/Objects/ObjectCreate";
import Commercial from "../components/Commercial";
import AdminBanks from "../components/admin/Banks/AdminBanks";
import AdminBanksUpdate from "../components/admin/Banks/AdminBanksUpdate";

const routes = [
    {
        path: '/',
        name: 'UserApp',
        component: UserApp,
        redirect: '/',
        children: [
            {
                path: '',
                name: 'home',
                component: Home
            },
            {
                path: 'objects',
                name: 'chooseObject',
                component: ChooseObject
            },
            {
                path: 'houses/:id',
                name: 'chooseHouse',
                component: ChooseHouse,
            },
            {
                path: 'building/:id',
                name: 'chooseFloor',
                component: ChooseFloor
            },
            {
                path: 'floors/:id/:name',
                name: 'chooseFlat',
                component: ChooseFlat,
                props: true
            },
            {
                path: 'flatList',
                name: 'flatList',
                component: FlatList,
                props: true
            },
            {
                path: 'commercial',
                name: 'commercial',
                component: Commercial,
                props: true
            },
            {
                path: 'flat/:id',
                name: 'flat',
                component: Flat
            },
            {
                path: 'about',
                name: 'about',
                component: About
            },
            {
                path: 'contacts',
                name: 'contacts',
                component: Contacts
            },
            {
                path: 'achievements',
                name: 'achievements',
                component: Achievements
            },
            {
                path: 'news',
                name: 'news',
                component: News
            },
            {
                path: 'news/:id',
                name: 'showNew',
                component: ShowNew,
                props: true
            },
            {
                path: '404',
                name: '404',
                component: NotFound,
            },
            {
                path: 'reserve/:id',
                name: 'reserve',
                component: Reserve,
            },
        ]
    },
    {
        path: '*',
        redirect: '/404'
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/admin',
        name: 'admin',
        component: AdminApp,
        redirect: '/admin/dashboard',
        meta: {
            auth: {roles: [2,3], redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        },
        children: [
            {
                path: 'dashboard',
                name: 'adminDashboard',
                component: AdminDashboard
            },
            {
                path: 'objects',
                name: 'adminObjects',
                component: AdminObjects,
                props: true
            },
            {
                path: 'objects/show/:id',
                name: 'adminObjectShow',
                component: ObjectShow,
                props: true
            },
            {
                path: 'objects/edit/:id',
                name: 'adminObjectEdit',
                component: ObjectEdit
            },
            {
                path: 'objects/create',
                name: 'adminObjectCreate',
                component: ObjectCreate
            },
            {
                path: 'objects/houses/create',
                name: 'adminHouseCreate',
                component: HouseCreate
            },
            {
                path: 'objects/houses/edit/:id',
                name: 'adminHouseEdit',
                component: HouseEdit,

            },
            {
                path: 'objects/houses/show/:id',
                name: 'adminHouseShow',
                component: HouseShow,
                props: true
            },
            {
                path: 'objects/houses/floor/show/:id',
                name: 'adminFloorShow',
                component: FloorShow,
                props: true,
            },
            {
                path: 'objects/houses/floor/edit/:id',
                name: 'adminFloorEdit',
                component: FloorEdit,
            },
            {
                path: 'objects/houses/floor/create',
                name: 'adminFloorCreate',
                component: FloorCreate,
            },
            {
                path: 'objects/houses/floor/flat/create',
                name: 'adminFlatCreate',
                component: FlatCreate,
            },
            {
                path: 'objects/houses/floor/flat/edit/:id',
                name: 'adminFlatEdit',
                component: FlatEdit,
            },
            {
                path: 'news',
                name: 'adminNews',
                component: AdminNews,
                props: true,
            },
            {
                path: 'news/create',
                name: 'adminNewsCreate',
                component: AdminNewCreate
            },
            {
                path: 'news/update/:id',
                name: 'adminNewsUpdate',
                component: AdminNewUpdate
            },
            {
                path: 'users',
                name: 'adminUsers',
                component: AdminUsers,
                props: true,
            },
            {
                path: 'users/user/:id',
                name: 'adminUserShow',
                component: AdminUserShow
            },
            {
                path: 'requests',
                name: 'adminRequests',
                component: AdminRequests
            },
            {
                path: 'reserves',
                name: 'adminReserves',
                component: AdminReserves
            },
            {
                path: 'prices',
                name: 'adminPrices',
                component: AdminPrices
            },
            {
                path: 'find',
                name: 'adminFindFlat',
                component: AdminFindFlat,
                props: true,
            },
            {
                path: 'find/ShowFlat/:id',
                name: 'adminShowFlat',
                component: AdminShowFlat,
                props: true,
            },
            {
                path: 'offices',
                name: 'adminOfficeShow',
                component: AdminOfficeShow,
                props: true,
            },
            {
                path: 'offices/edit/:id',
                name: 'adminOfficeUpdate',
                component: OfficeUpdate
            },
            {
                path: 'offices/create',
                name: 'adminOfficeCreate',
                component: OfficeCreate
            },
            {
                path: 'pantries',
                name: 'adminPantryShow',
                component: AdminPantryShow,
                props: true,
            },
            {
                path: 'pantries/edit/:id',
                name: 'adminPantryEdit',
                component: PantryEdit
            },
            {
                path: 'pantries/create',
                name: 'adminPantryCreate',
                component: PantryCreate
            },
            {
                path: 'documents',
                name: 'adminDocuments',
                component: AdminDocuments,
                props: true,
            },
            {
                path: 'documents/edit/:id',
                name: 'adminDocumentsEdit',
                component: DocUpdate
            },
            {
                path: 'documents/create',
                name: 'adminDocumentsCreate',
                component: DocCreate
            },
            {
                path: 'photoReports',
                name: 'photoReports',
                component: AdminPhotoReport,
                props: true
            },
            {
                path: 'photoReports/create',
                name: 'photoReportsCreate',
                component: PhotoReportCreate,
            },
            {
                path: 'photoReports/edit/:id',
                name: 'photoReportsEdit',
                component: PhotoReportEdit,
            },
            {
                path: 'banks',
                name: 'adminBanks',
                component: AdminBanks,
                props: true
            },
            {
                path: 'banks/:id/update',
                name: 'adminBanksUpdate',
                component: AdminBanksUpdate
            },
        ]
    }
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});

export default router
