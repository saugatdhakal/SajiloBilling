import { ref } from '@vue/reactivity';
import axios from 'axios';
const getPurchaseDataView = () => {
    const purchaseDetails = ref({});
    const pLoading = ref(false);
    const purchaseError = ref({});
    const requestPurchaseData = async (id) => {
        axios.get('api/purchase/viewPurchaseDetails/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            pLoading.value = false;
            purchaseDetails.value = res.data;
        }).catch((resErr) => {
            pLoading.value = false;
            purchaseError.value = resErr;
        })
    }
    return { purchaseDetails, pLoading, purchaseError, requestPurchaseData }
}
export default getPurchaseDataView;

