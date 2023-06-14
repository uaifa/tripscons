export default function checkUserType({ next, router }) {
    console.log("okasdfasdfasdf");
    if (localStorage.getItem('type') && localStorage.getItem('type') == 0) {
        return router.push({ name: '/' });
    } else if (localStorage.getItem('type') && localStorage.getItem('type') == 1) {
        return router.push({ name: '/user/setting' });
    } else if (localStorage.getItem('type') && localStorage.getItem('type') == 2) {
        return router.push({ name: '/host/dashboard' });
    }
    return router.push({ name: '/login' });

}