# coding:utf-8

# https://www.freesion.com/article/4355613252/

# 备注: 设置网卡混杂模式:socket.ioctl仅使用于windows平台,故此程序仅可以在win正常运行

import socket
import struct
import json

class Server():

    def __init__(self):
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_RAW, socket.IPPROTO_IP)

        self.sock.bind(('192.168.31.66', 8888))

        self.sock.ioctl(socket.SIO_RCVALL, socket.RCVALL_ON)

    def loopServe(self):
        while True:
            packet, addr, = self.sock.recvfrom(65535)
            IPParser.parsePacket(packet)



class IPParser():

    @classmethod
    def parsePacket(cls, packet):
        ip_row_num, ip_header_bytes = cls.getHeaderFromPacket(packet)

        ip_heder_dict = cls.parseHeader(ip_row_num, ip_header_bytes)

        cls.printHeader(ip_heder_dict)


    @classmethod
    def getHeaderFromPacket(cls, packet):
        """
        line1: 版本4 + 首部长度4bit(单位:字节)  (32bit) = 4byte
        line2: 偏移    (32bit)
        line3: TTL    (32bit)
        line4: 源地址  (32bit)
        line5: 目的地址(32bit)
        共计: 32bit*5line=4byte*5line=20byte

        接收的数据包是字节流,一个字节通常表示为:0xFF
        eg: b'E\x00\x00(\xa1\x0b@\x00@\x06\x00\x00\xc0\xa8\x1fBpP\xf8\xfb'
        """

        # eg: b'E'
        version_and_length = packet[0:1]

        # eg: 69,  unpack按byte解析
        (version_and_length_int,) = struct.unpack('>B', version_and_length)

        # eg: 20   ,   int & int, 单位:行
        ip_row_num = version_and_length_int & 0b00001111
        ip_byte_len = ip_row_num * 4

        return ip_row_num, packet[:ip_byte_len]

    @classmethod
    def printHeader(self, header):
        """
        {
            'ip_version': ip_version,
            'iph_length': iph_length,
            'ip_service_type': ip_service_type,
            'packet_length': packet_length,

            'TTL': TTL,
            'protocol': protocol,
            'iph_checksum': iph_checksum,

            'src_ip': src_ip,

            'dst_ip': dst_ip
        }
        """

        rows = []
        items = []
        for i,v in enumerate(header['headers_bit']):
            items.append(v)
            if i % 4 == 3:
                rows.append(items)
                items = []

        print("-----------------原数据-----------------------")
        for i,line in enumerate(rows):
            print(
                "[{:08b}    {:08b}    {:08b}    {:08b}]".format(
                    line[0], line[1], line[2], line[3]
                )
            )
        print("---------------------------------------------")
        print("-----------------解析后-----------------------")
        for i,line in enumerate(rows):
            if i == 0:
                print(
                    "[{:08b}    {:08b}    {:08b}    {:08b}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
                print(
                    "[{:8s}    {:8s}    {:>16s}    ]".format(
                        str(header['ip_version']) + " | " + str(header['iph_length'] * 4),
                        'srv_type',
                        "ip_len:" + str(line[2] * (2 ** 8) + line[3])
                    )
                )
            elif i == 1:
                print(
                    "[{:08b}    {:08b}    {:08b}    {:08b}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
            elif i == 2:
                print(
                    "[{:08b}    {:08b}    {:08b}    {:08b}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
            elif i == 3:
                print(
                    "[{:08b}    {:08b}    {:08b}    {:08b}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
                print(
                    "[{:>8d}    {:>8d}    {:>8d}    {:>8d}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
            elif i == 4:
                print(
                    "[{:08b}    {:08b}    {:08b}    {:08b}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
                print(
                    "[{:>8d}    {:>8d}    {:>8d}    {:>8d}]".format(
                        line[0], line[1], line[2], line[3]
                    )
                )
            if i != len(rows) - 1:
                print("")
        print("----------------------------------------------")

        print("")


        # print(header['headers_bit'])

        # print("[{:08b}    {:08b}    {:016b}]".format(
        #     header['line1'][0], header['line1'][1], header['line1'][2],
        # ))
        # print("[版本-长度    -服务类型--   ------总长度--------]")
        # print("[{:d}    -服务类型--  -----总长度--------]".format(header['ip_version']))

        # print("[0000 0000  0000 0000  0000 0000 0000 0000]")
        # print("[版本- -长度 -服务类型--  -----总长度--------]")


        # print(
        #     json.dumps(
        #         header,
        #         indent=4
        #     )
        # )

    @classmethod
    def parseHeader(cls, ip_row_num, ip_header):
        """
        IP报文格式
        1. 4位IP-version 4位IP头长度 8位服务类型 16位报文总长度  1~4
        2. 16位标识符 3位标记位 13位片偏移 暂时不关注此行         5~8
        3. 8位TTL 8位协议 16位头部校验和                       9~12
        4. 32位源IP地址                                         13~16
        5. 32位目的IP地址                                   17~20
        6. 剩下的就是选项, 4byte整数倍                        21:
        :param ip_header:
        :return:
        """
        line1 = struct.unpack('>BBH', ip_header[:4])  # 先按照8位、8位、16位解析
        ip_version = line1[0] >> 4  # 通过右移4位获取高四位
        ip_service_type = line1[1]
        # 报文头部长度的单位是32位 即四个字节
        iph_length = (line1[0] & 0b00001111)  # 与1111与运算获取低四位,单位byte
        packet_length = line1[2] # 整个ip数据报的长度:单位byte

        line3 = struct.unpack('>BBH', ip_header[8: 12])
        TTL = line3[0]
        protocol = line3[1]
        iph_checksum = line3[2]

        line4 = struct.unpack('>4s', ip_header[12: 16])
        src_ip = socket.inet_ntoa(line4[0])
        line5 = struct.unpack('>4s', ip_header[16: 20])
        dst_ip = socket.inet_ntoa(line5[0])

        # 返回结果
        # ip_version ip版本
        # iph_length ip头部长度
        # packet_length 报文长度
        # TTL 报文寿命
        # protocol 协议号 1 ICMP协议 6 TCP协议 17 UDP协议
        # iph_checksum ip头部的校验和
        # src_ip 源ip
        # dst_ip 目的ip
        return {
            'ip_version': ip_version,
            'ip_service_type': ip_service_type,
            'iph_length': iph_length,
            'packet_length': packet_length,


            'TTL': TTL,
            'protocol': protocol,
            'iph_checksum': iph_checksum,

            'src_ip': src_ip,

            'dst_ip': dst_ip,

            'headers_bit': struct.unpack('BBBB' * ip_row_num, ip_header)
        }


if __name__ == '__main__':
    server = Server()
    server.loopServe()



















"""
结果示例:

-----------------原数据-----------------------
[01000101    00000000    00000000    01000100]
[00001010    10001001    00000000    00000000]
[00000001    00010001    00000000    00000000]
[11000000    10101000    00011111    01000010]
[11100000    00000000    00000000    11111101]
---------------------------------------------
-----------------解析后-----------------------
[01000101    00000000    00000000    01000100]
[4 | 20      srv_type           ip_len:68    ]

[00001010    10001001    00000000    00000000]

[00000001    00010001    00000000    00000000]

[11000000    10101000    00011111    01000010]
[     192         168          31          66]

[11100000    00000000    00000000    11111101]
[     224           0           0         253]
----------------------------------------------


"""