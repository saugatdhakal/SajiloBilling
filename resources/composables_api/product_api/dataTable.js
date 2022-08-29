import { ref } from '@vue/reactivity';
import axios from 'axios';


const dataTable = () => {
    const products = ref({});
    const productLoading = ref(true);
    const productError = ref({});

    const getProducts = async ({page=1,paginate,search,selectedType="",deleteData=false}) => {
        await axios.get('api/product/dataTables?page='+page+
        '&paginate='+paginate+
        '&search='+search+
        '&deleteData='+deleteData+
        '&selectedType='+selectedType, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            products.value = res.data;
            productLoading.value = false;
            // console.log(products.value);
        }).catch((resErr) => {
            productLoading.value = false;
            productError.value = resErr;
        })
    }
    return { products, productLoading, productError, getProducts }
}
export default dataTable;
