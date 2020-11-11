export const revenuesIndex = params => window.axios.get("/api/revenues", { params });

export const revenueUpdate = (id, data) => window.axios.patch(`/api/revenues/${ id }`, data);

export const revenueDestroy = id => window.axios.delete(`/api/revenues/${ id }`);

export const revenueEmail = data => window.axios.post("/api/revenues/email", data);

export const revenuesSummary = params => window.axios.get("/api/revenues/summary", { params });
