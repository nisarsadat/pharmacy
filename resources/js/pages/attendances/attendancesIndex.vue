<template>
    <div class="attendance-container">
        <!-- Header Section -->

        <v-card class="date-card py-1 my-5" elevation="0" variant="outlined">
            <div class="date-card-content">
                <v-icon color="primary" size="20">mdi-calendar</v-icon>
                <v-text-field
                    v-model="selectedDate"
                    type="date"
                    label="Select Date"
                    variant="outlined"
                    density="comfortable"
                    hide-details
                    class="date-input"
                />
            </div>
        </v-card>

        <!-- Table Section -->
        <v-card class="table-card" elevation="0" variant="outlined">
            <v-data-table-server
                :headers="headers"
                :items="employees"
                item-value="id"
                :default-sort="[{ key: 'name', order: 'asc' }]"
                hover
            >
                <!-- Employee Column -->
                <template v-slot:item.employee="{ item }">
                    <div class="employee-cell">
                        <v-avatar
                            size="36"
                            class="employee-avatar"
                            color="grey-lighten-3"
                        >
                            <v-img
                                v-if="item.image"
                                :src="item.image"
                                alt="avatar"
                            ></v-img>
                            <span v-else class="avatar-placeholder">
                                {{ getInitials(item.name) }}
                            </span>
                        </v-avatar>
                        <span class="employee-name">{{ item.name }}</span>
                    </div>
                </template>

                <!-- Check In Column -->
                <template v-slot:item.check_in="{ item }">
                    <div class="time-input-wrapper">
                        <v-icon size="18" color="grey" class="time-icon"
                            >mdi-login</v-icon
                        >
                        <v-text-field
                            v-model="attendanceMap[item.id].check_in"
                            type="time"
                            density="compact"
                            variant="outlined"
                            hide-details
                            class="time-input"
                            placeholder="--:--"
                        />
                    </div>
                </template>

                <!-- Check Out Column -->
                <template v-slot:item.check_out="{ item }">
                    <div class="time-input-wrapper">
                        <v-icon size="18" color="grey" class="time-icon"
                            >mdi-logout</v-icon
                        >
                        <v-text-field
                            v-model="attendanceMap[item.id].check_out"
                            type="time"
                            density="compact"
                            variant="outlined"
                            hide-details
                            class="time-input"
                            placeholder="--:--"
                        />
                    </div>
                </template>

                <!-- Status Column -->
                <template v-slot:item.status="{ item }">
                    <div class="status-buttons">
                        <v-btn
                            :variant="
                                attendanceMap[item.id].status === 'present'
                                    ? 'flat'
                                    : 'text'
                            "
                            :color="
                                attendanceMap[item.id].status === 'present'
                                    ? 'success'
                                    : 'default'
                            "
                            size="small"
                            class="status-btn"
                            @click="attendanceMap[item.id].status = 'present'"
                        >
                            <v-icon size="16" start>mdi-check-circle</v-icon>
                            Present
                        </v-btn>
                        <v-btn
                            :variant="
                                attendanceMap[item.id].status === 'absent'
                                    ? 'flat'
                                    : 'text'
                            "
                            :color="
                                attendanceMap[item.id].status === 'absent'
                                    ? 'error'
                                    : 'default'
                            "
                            size="small"
                            class="status-btn"
                            @click="attendanceMap[item.id].status = 'absent'"
                        >
                            <v-icon size="16" start>mdi-close-circle</v-icon>
                            Absent
                        </v-btn>
                        <v-btn
                            :variant="
                                attendanceMap[item.id].status === 'leave'
                                    ? 'flat'
                                    : 'text'
                            "
                            :color="
                                attendanceMap[item.id].status === 'leave'
                                    ? 'warning'
                                    : 'default'
                            "
                            size="small"
                            class="status-btn"
                            @click="attendanceMap[item.id].status = 'leave'"
                        >
                            <v-icon size="16" start>mdi-beach</v-icon>
                            Leave
                        </v-btn>
                    </div>
                </template>
                <!-- ✅ Action Column -->
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        color="secondary"
                        size="small"
                        variant="outlined"
                        @click="saveSingleAttendance(item)"
                    >
                        <v-icon start size="16">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                </template>
                <!-- Custom empty state -->
                <template v-slot:no-data>
                    <div class="empty-state">
                        <v-icon size="48" color="grey-lighten-1"
                            >mdi-account-group</v-icon
                        >
                        <p>No employees found</p>
                    </div>
                </template>
            </v-data-table-server>
        </v-card>

        <!-- Submit Section -->
        <div class="submit-section">
            <div class="summary-badge">
                <v-icon size="18" color="primary">mdi-chart-box</v-icon>
                <span>
                    {{ getPresentCount }} Present · {{ getAbsentCount }} Absent
                    · {{ getLeaveCount }} Leave
                </span>
            </div>
            <v-btn
                color="primary"
                size="large"
                @click="submitAttendance"
                class="submit-btn"
                elevation="0"
            >
                <v-icon start>mdi-content-save</v-icon>
                Save Attendance
            </v-btn>
        </div>

        <!-- Snackbar for notifications -->
        <v-snackbar
            v-model="snackbar.show"
            :color="snackbar.color"
            :timeout="3000"
            location="top end"
        >
            <v-icon start size="20">{{ snackbar.icon }}</v-icon>
            {{ snackbar.text }}
        </v-snackbar>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import axios from "@/plugins/axios";
import { usePeopleRepository } from "@/repositories/PeopleRepository";

const repo = usePeopleRepository();
// 📅 Selected date
const selectedDate = ref(new Date().toISOString().substr(0, 10));

// 👨‍💼 Employees list
const employees = ref([]);

// 🧠 Attendance Map
const attendanceMap = reactive({});

// Snackbar state
const snackbar = ref({
    show: false,
    text: "",
    color: "success",
    icon: "mdi-check-circle",
});

// 🧾 Table headers
const headers = [
    { title: "Employee", key: "employee", sortable: true, width: "250" },
    {
        title: "Check In",
        key: "check_in",
        sortable: false,
        align: "start",
    },
    {
        title: "Check Out",
        key: "check_out",
        sortable: false,
        align: "start",
    },
    {
        title: "Status",
        key: "status",
        sortable: false,
        align: "start",
    },
    { title: "Action", key: "actions", sortable: false },
];

// Computed summary
const getPresentCount = computed(() => {
    return Object.values(attendanceMap).filter((a) => a.status === "present")
        .length;
});

const getAbsentCount = computed(() => {
    return Object.values(attendanceMap).filter((a) => a.status === "absent")
        .length;
});

const getLeaveCount = computed(() => {
    return Object.values(attendanceMap).filter((a) => a.status === "leave")
        .length;
});

// Helper function
const getInitials = (name) => {
    return name
        .split(" ")
        .map((word) => word[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
};

// 🚀 Fetch employees
const fetchEmployees = async () => {
    try {
        const res = await axios.get("employees");
        employees.value = res.data.data;

        // Initialize attendance map
        employees.value.forEach((emp) => {
            attendanceMap[emp.id] = {
                employee_id: emp.id,
                check_in: "",
                check_out: "",
                status: "present",
                note: "",
            };
        });
    } catch (error) {
        console.error(error);
        snackbar.value = {
            show: true,
            text: "Failed to load employees",
            color: "error",
            icon: "mdi-alert-circle",
        };
    }
};

// 💾 Submit all attendance
const submitAttendance = async () => {
    const payload = Object.values(attendanceMap).map((item) => ({
        ...item,
        date: selectedDate.value,
    }));

    try {
        await axios.post("attendances/bulk", payload);
        snackbar.value = {
            show: true,
            text: "Attendance saved successfully",
            color: "success",
            icon: "mdi-check-circle",
        };
    } catch (error) {
        console.error(error);
        snackbar.value = {
            show: true,
            text: "Failed to save attendance",
            color: "error",
            icon: "mdi-alert-circle",
        };
    }
};
const saveSingleAttendance = async (employee) => {
    const data = {
        ...attendanceMap[employee.id],
        date: selectedDate.value,
    };

    try {
        await repo.createattendances(data);

        snackbar.value = {
            show: true,
            text: `Attendance saved for ${employee.name}`,
            color: "success",
            icon: "mdi-check-circle",
        };
    } catch (error) {
        console.error(error);
        snackbar.value = {
            show: true,
            text: `Failed for ${employee.name}`,
            color: "error",
            icon: "mdi-alert-circle",
        };
    }
};
onMounted(() => {
    fetchEmployees();
});
</script>

<style scoped>
.attendance-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
    background: #f5f7fb;
    min-height: 100vh;
}

/* Header Section */
.header-section {
    margin-bottom: 28px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.title-section {
    display: flex;
    align-items: center;
    gap: 16px;
}

.title-icon {
    width: 52px;
    height: 52px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-title {
    font-size: 28px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 4px 0;
    letter-spacing: -0.3px;
}

.page-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.date-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
}

.date-card-content {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 16px;
}

.date-input {
    width: 180px;
}

/* Table Card */
.table-card {
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    background: white;
}

/* Custom Table Styles */
.custom-table :deep(.v-data-table-header) {
    background-color: #fafbfc;
}

.custom-table :deep(th) {
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
}

.custom-table :deep(td) {
    border-bottom: 1px solid #f0f2f5;
    padding: 16px 12px;
}

/* Employee Cell */
.employee-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.employee-avatar {
    flex-shrink: 0;
}

.avatar-placeholder {
    font-size: 14px;
    font-weight: 500;
    color: #4f46e5;
    background: #eef2ff;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.employee-name {
    font-weight: 500;
    color: #1f2937;
}

/* Time Input Wrapper */
.time-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.time-icon {
    opacity: 0.6;
}

.time-input {
    max-width: 120px;
}

.time-input :deep(.v-field) {
    border-radius: 10px;
}

.time-input :deep(.v-field__input) {
    font-family: monospace;
    font-size: 14px;
}

/* Status Buttons */
.status-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.status-btn {
    border-radius: 20px !important;
    text-transform: none !important;
    font-weight: 500 !important;
    font-size: 12px !important;
    padding: 4px 12px !important;
    min-width: 80px;
    transition: all 0.2s ease;
}

.status-btn:hover {
    transform: translateY(-1px);
}

/* Submit Section */
.submit-section {
    margin-top: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.summary-badge {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 40px;
    padding: 8px 20px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
}

.submit-btn {
    border-radius: 40px !important;
    text-transform: none !important;
    font-weight: 600 !important;
    padding: 0 32px !important;
    letter-spacing: 0.3px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px;
}

.empty-state p {
    margin-top: 12px;
    color: #9ca3af;
}

/* Responsive */
@media (max-width: 768px) {
    .attendance-container {
        padding: 16px;
    }

    .page-title {
        font-size: 22px;
    }

    .title-icon {
        width: 44px;
        height: 44px;
    }

    .status-buttons {
        flex-direction: column;
        gap: 6px;
    }

    .status-btn {
        width: 100%;
        justify-content: center;
    }

    .header-content {
        flex-direction: column;
        align-items: stretch;
    }

    .date-card {
        align-self: flex-start;
    }

    .submit-section {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .summary-badge {
        justify-content: center;
    }

    .submit-btn {
        width: 100%;
    }
}
</style>
