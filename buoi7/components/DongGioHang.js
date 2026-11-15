// components/DongGioHang.js
export default {
    name: 'DongGioHang',
    // Yêu cầu 2: Nhận dữ liệu của từng sản phẩm từ cha qua props
    props: {
        id: {
            type: Number,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        price: {
            type: Number,
            required: true
        },
        quantity: {
            type: Number,
            required: true
        }
    },
    // Yêu cầu 3: Khai báo tường minh các sự kiện tùy chỉnh (emits)
    emits: ['doi-so-luong', 'yeu-cau-xoa'],
    computed: {
        // Yêu cầu 2: Tự tính thành tiền ở con (Thành tiền = Đơn giá x Số lượng)
        lineTotal() {
            return this.price * this.quantity;
        }
    },
    methods: {
        // Yêu cầu 6: Không sửa đổi trực tiếp thuộc tính props, phát tín hiệu cho cha xử lý
        changeQty(amount) {
            const newQty = this.quantity + amount;
            // Yêu cầu 5: Ràng buộc số lượng chỉ nhận giá trị từ 1 đến 99
            if (newQty >= 1 && newQty <= 99) {
                this.$emit('doi-so-luong', this.id, newQty);
            }
        },
        // Yêu cầu 6: Xử lý thay đổi trực tiếp từ input dạng số
        onInputQty(event) {
            let value = parseInt(event.target.value);
            // Nếu nhập không phải số hoặc nhỏ hơn 1, đưa về 1. Nếu lớn hơn 99, chặn ở 99.
            if (isNaN(value) || value < 1) value = 1;
            if (value > 99) value = 99;
            
            this.$emit('doi-so-luong', this.id, value);
        },
        // Yêu cầu 3: Phát sự kiện yêu cầu xóa, đính kèm ID sản phẩm
        removeRow() {
            this.$emit('yeu-cau-xoa', this.id);
        },
        formatPrice(val) {
            return val.toLocaleString('vi-VN') + ' đ';
        }
    },
    template: `
        <tr class="bg-white border-b hover:bg-gray-50">
            <td class="px-6 py-4 font-semibold text-gray-900">{{ name }}</td>
            <td class="px-6 py-4 text-gray-700 text-right">{{ formatPrice(price) }}</td>
            <td class="px-6 py-4 text-center">
                <!-- Khu vực điều chỉnh số lượng -->
                <div class="flex items-center justify-center gap-1">
                    <!-- Nút giảm số lượng (Khóa nếu số lượng bằng 1) -->
                    <button 
                        @click="changeQty(-1)" 
                        :disabled="quantity <= 1"
                        class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded disabled:opacity-40 disabled:cursor-not-allowed">
                        -
                    </button>
                    
                    <!-- Ô nhập số lượng thủ công -->
                    <input 
                        type="number" 
                        :value="quantity" 
                        @change="onInputQty"
                        class="w-12 text-center border border-gray-300 rounded py-0.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 font-medium">
                    
                    <!-- Nút tăng số lượng (Khóa nếu số lượng đạt tối đa 99) -->
                    <button 
                        @click="changeQty(1)" 
                        :disabled="quantity >= 99"
                        class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded disabled:opacity-40 disabled:cursor-not-allowed">
                        +
                    </button>
                </div>
            </td>
            <!-- Hiển thị thành tiền -->
            <td class="px-6 py-4 font-bold text-blue-600 text-right">{{ formatPrice(lineTotal) }}</td>
            <td class="px-6 py-4 text-center">
                <button 
                    @click="removeRow" 
                    class="font-medium text-red-600 hover:underline text-sm">
                    Xóa
                </button>
            </td>
        </tr>
    `
};
