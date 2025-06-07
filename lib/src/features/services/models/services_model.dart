import 'package:cloud_firestore/cloud_firestore.dart';

class ServicesModel {
  String? id;
  final String serviceAddress;
  final String serviceName;
  final String serviceDesc;
  final double serviceLng;
  final double serviceLat;
  final String serviceGoogleLink;
  final String serviceWazeLink;
  final int serviceAvailable;
  final int serviceTotal;
  final bool serviceStatus;
  final bool serviceRfidStatus;
  String? distance;

  ServicesModel({
    this.id,
    required this.serviceAddress,
    required this.serviceName,
    required this.serviceDesc,
    required this.serviceLng,
    required this.serviceLat,
    required this.serviceGoogleLink,
    required this.serviceWazeLink,
    required this.serviceAvailable,
    required this.serviceTotal,
    required this.serviceStatus,
    required this.serviceRfidStatus,
    this.distance,
  });

  static ServicesModel empty() => ServicesModel(id: '', serviceAddress: '', serviceName: '', serviceDesc: '', serviceLng: 0.0, serviceLat: 0.0, serviceGoogleLink: '', serviceWazeLink: '', serviceAvailable: 0, serviceTotal: 0, serviceStatus: true, serviceRfidStatus: false);

  Map<String, dynamic> toJson() {
    return {
      'service_address': serviceAddress,
      'service_name': serviceName,
      'service_desc': serviceDesc,
      'service_longitude': serviceLng,
      'service_latitude': serviceLat,
      'service_google_link': serviceGoogleLink,
      'service_waze_link': serviceWazeLink,
      'service_available': serviceAvailable,
      'service_total': serviceTotal,
      'service_status': serviceStatus,
      'service_rfid_status': serviceRfidStatus,
    };
  }

  factory ServicesModel.fromSnapshot(DocumentSnapshot<Map<String, dynamic>> document) {
    if (document.data() != null) {
      final data = document.data()!;
      return ServicesModel(
        id: document.id,
        serviceAddress: data['service_address'] ?? '',
        serviceName:  data['service_name'] ?? '',
        serviceDesc: data['service_desc'] ?? '',
        serviceLng: data['service_longitude'] ?? 0.0,
        serviceLat: data['service_latitude'] ?? 0.0,
        serviceGoogleLink: data['service_google_link'] ?? '',
        serviceWazeLink: data['service_waze_link'] ?? '',
        serviceAvailable: data['service_available'] ?? 0,
        serviceTotal: data['service_total'] ?? 0,
        serviceStatus: data['service_status'] ?? true,
        serviceRfidStatus: data['service_rfid_status'] ?? false,
      );
    } else {
      return ServicesModel.empty();
    }
  }

  factory ServicesModel.fromQueryDocSnapshot(QueryDocumentSnapshot<Object?> document) {
    if (document.data() != null) {
      final data = document.data() as Map<String, dynamic>;
      return ServicesModel(
        id: document.id,
        serviceAddress: data['service_address'] ?? '',
        serviceName:  data['service_name'] ?? '',
        serviceDesc: data['service_desc'] ?? '',
        serviceLng: data['service_longitude'] ?? 0.0,
        serviceLat: data['service_latitude'] ?? 0.0,
        serviceGoogleLink: data['service_google_link'] ?? '',
        serviceWazeLink: data['service_waze_link'] ?? '',
        serviceAvailable: data['service_available'] ?? 0,
        serviceTotal: data['service_total'] ?? 0,
        serviceStatus: data['service_status'] ?? true,
        serviceRfidStatus: data['service_rfid_status'] ?? false,
      );
    } else {
      return ServicesModel.empty();
    }
  }
}