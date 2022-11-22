import { ref } from '@vue/reactivity';
import axios from 'axios';
const getProductNameId = () => {
    const productDetails = ref([]);
    const pLoading = ref(false);
    const productError = ref({});
    const apiResquestProduct = async (search) => {
      await axios.get('api/product/getProductNameId?q='+search, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            console.log(res.data)
            pLoading.value = false;
            productDetails.value = res.data;
        }).catch((resErr) => {
            pLoading.value = false;
            productError.value = resErr;
        })
    }
    return { productDetails, pLoading, productError, apiResquestProduct }
}
export default getProductNameId;
