import { ref } from '@vue/reactivity';
import axios from 'axios';


const purchaseDataTable = () => {
    const purchase = ref({});
    const purchaseLoading = ref(true);
    const purchaseError = ref({});

    const getTableData = async ({page=1,paginate,search,selectedType="",deleteData=false}) => {
        await axios.get('api/purchase/getDatatable?page='+page+
        '&paginate='+paginate+
        '&search='+search+
        '&deleteData='+deleteData+
        '&selectedType='+selectedType, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            purchase.value = res.data;
            purchaseLoading.value = false;
            // console.log(purchase.value);
        }).catch((resErr) => {
            purchaseLoading.value = false;
            purchaseError.value = resErr;
        })
    }
    return { purchase, purchaseLoading, purchaseError, getTableData }
}
export default purchaseDataTable;
