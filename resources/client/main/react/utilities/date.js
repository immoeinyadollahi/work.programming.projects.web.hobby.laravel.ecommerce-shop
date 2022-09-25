import moment from "moment";

export const formatDate = (date = new Date(), pattern = "D MMM YYYY") => moment(date).format(pattern);

export const formatDateTime = (date = new Date(), pattern = "HH:mm") => moment(date).format(pattern);

export const getDatesBetween = (startDate, endDate, addUnit) => {
  let dates = [];
  for (let date = moment(startDate); date.isSameOrBefore(endDate); date.add(1, addUnit)) {
    dates.push(date.toDate());
  }
  return dates;
};
