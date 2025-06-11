import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:serbizio_ph_web_privacy_policy/src/utils/helpers/formatter.dart';

class UserModel {
  final String id;
  final String emailAddress;
  String firstName;
  String middleName;
  String lastName;
  String pw;
  String mobileNumber;
  String? deviceId;
  bool? isActive;
  bool? status;

  // Constructor
  UserModel({
    required this.id,
    required this.firstName,
    required this.middleName,
    required this.lastName,
    required this.emailAddress,
    required this.pw,
    required this.mobileNumber,
    required this.deviceId,
    this.isActive,
    this.status
  });

  String get formattedPhoneNo => Formatter.formatPhoneNumber(mobileNumber);

  static UserModel empty() => UserModel(
    id: '',
    firstName: '',
    middleName: '',
    lastName: '',
    emailAddress: '',
    pw: '',
    mobileNumber: '',
    deviceId: '',
    isActive: true,
    status: false
  );

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'first_name': firstName,
      'middle_name': middleName,
      'last_name': lastName,
      'email_address': emailAddress,
      'p': pw,
      'mobile_number': mobileNumber,
      'device_id': deviceId,
      'is_active': true,
      'status': true
    };
  }

  // Factory method to create a UserModel from a Firebase document snapshot
  factory UserModel.fromSnapshot(DocumentSnapshot<Map<String, dynamic>> document) {
    if (document.data() != null) {
      final data = document.data()!;
      return UserModel(
        id: document.id,
        firstName: data['first_name'] ?? '',
        middleName: data['middle_name'] ?? '',
        lastName: data['last_name'] ?? '',
        emailAddress: data['email_address'] ?? '',
        pw: data['p'] ?? '',
        mobileNumber: data['mobile_number'] ?? '',
        deviceId: data['device_id'] ?? '',
        isActive: data['is_active'] ?? '',
        status: data['status'] ?? '',
      );
    }
    return UserModel.empty();
  }
}