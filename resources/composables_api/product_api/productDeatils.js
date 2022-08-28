import { ref } from '@vue/reactivity';
import axios from 'axios';
const getProductDetails = () => {
    const productDetails = ref([]);
    const pLoading = ref(false);
    const productError = ref({});
    const apiResquestProduct = async (id) => {
        axios.get('api/product/getProductDetails/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            pLoading.value = false;
            productDetails.value = res.data;
            // console.log(res.data);
        }).catch((resErr) => {
            pLoading.value = false;
            productError.value = resErr;
        })
    }
    return { productDetails, pLoading, productError, apiResquestProduct }
}
export default getProductDetails;

