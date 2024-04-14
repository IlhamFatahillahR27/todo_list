import moment from "moment/moment";

export const dateTimeFormatter = (
    value = null,
    format = "DD MMMM YYYY HH:mm"
) => {
    if (!value) {
        return " - ";
    }

    return moment(value).format(format);
};

export const moneyFormat = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(number);
};
